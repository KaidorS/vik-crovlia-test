<?php

namespace App\Filament\Resources\Reports;

use App\Filament\Resources\Reports\Pages\CreateReport;
use App\Filament\Resources\Reports\Pages\EditReport;
use App\Filament\Resources\Reports\Pages\ListReports;
use App\Filament\Resources\Reports\Schemas\ReportForm;
use App\Filament\Resources\Reports\Tables\ReportsTable;
use App\Models\Report;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class ReportResource extends Resource
{
    protected static ?string $navigationLabel = 'Отчёты по выручке';
    protected static ?string $modelLabel = 'отчёт';
    protected static ?string $pluralModelLabel = 'Отчёты';

    protected static ?string $model = Report::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        /** @var User|null $user */
        $user = auth()->user();

        if ($user && !$user->hasAnyRole(['super_admin', 'panel_user'])) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        if ($user->hasAnyRole(['super_admin', 'panel_user'])) return true;
        // не-админ может создавать, но с ограничением (таймер)
        return true;
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = auth()->user();
        if (!$user) return false;
        if ($user->hasAnyRole(['super_admin', 'panel_user'])) return true;
        return false; // не-админы не могут редактировать ничего
    }

    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = auth()->user();
        if (!$user) return false;
        if ($user->hasAnyRole(['super_admin', 'panel_user'])) return true;
        return false; // не-админы не могут редактировать ничего
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'panel_user'])) {
            if (Report::hasTodayReportForUser($user->id)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'user_id' => 'Вы уже создали отчёт сегодня. Повторная публикация возможна после полуночи.',
                ]);
            }
            $data['user_id'] = $user->id;
        }
        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReports::route('/'),
            'create' => CreateReport::route('/create'),
            'edit' => EditReport::route('/{record}/edit'),
        ];
    }
}

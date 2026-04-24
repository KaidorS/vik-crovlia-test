<?php

namespace App\Filament\Resources\News;

use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\News\Pages\EditNews;
use App\Filament\Resources\News\Pages\ListNews;
use App\Models\News;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\News\Schemas\NewsForm;
use App\Filament\Resources\News\Tables\NewsTable;
use Illuminate\Database\Eloquent\Builder;

class NewsResource extends Resource
{
    protected static ?string $navigationLabel = 'Новости';

    protected static ?string $model = News::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return NewsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Новости';
    }

    // (опционально) изменить метку модели для страниц
    public static function getModelLabel(): string
    {
        return 'новость';
    }

    // Видимость пункта меню
    public static function shouldRegisterNavigation(): bool
    {
        return true; // покажем всем, но фильтрация будет в таблице
    }

    // Права на создание (не-админы могут создавать)
    public static function canCreate(): bool
    {
        return true; // любой авторизованный может создать новость (автор автоматически подставится)
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

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = auth()->user();
        if (!$user) return false;
        if ($user->hasAnyRole(['super_admin', 'panel_user'])) return true;
        return $record->user_id === $user->id;
    }

    public static function canDelete($record): bool
    {
        return static::canEdit($record);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'edit' => EditNews::route('/{record}/edit'),
        ];
    }
}

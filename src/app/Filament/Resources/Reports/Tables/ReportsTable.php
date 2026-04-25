<?php

namespace App\Filament\Resources\Reports\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Сотрудник')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('address')
                    ->label('Адрес точки продаж')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('revenue')
                    ->label('Выручка за день')
                    ->money('rub')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->toggleable()
                    ->sortable(),
            ])
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Сотрудник')
                    ->options(User::pluck('name', 'id')),
                Filter::make('month_year')
                    ->label('Месяц и год')
                    ->form([
                        Select::make('month')
                            ->label('Месяц')
                            ->options([
                                1 => 'Январь', 2 => 'Февраль', 3 => 'Март',
                                4 => 'Апрель', 5 => 'Май', 6 => 'Июнь',
                                7 => 'Июль', 8 => 'Август', 9 => 'Сентябрь',
                                10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь',
                            ]),
                        TextInput::make('year')
                            ->label('Год')
                            ->placeholder('2026')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['month'], fn($q) => $q->whereMonth('created_at', $data['month']))
                            ->when($data['year'], fn($q) => $q->whereYear('created_at', $data['year']));
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
                DeleteAction::make()
                    ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Reports\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Для администраторов – выбор пользователя, для обычных – скрытое поле
                auth()->user()?->hasAnyRole(['super_admin', 'panel_user'])
                    ? Select::make('user_id')
                    ->label('Сотрудник')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    : \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),

                TextInput::make('address')
                    ->label('Адрес точки продаж')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('revenue')
                    ->label('Выручка за день')
                    ->required()
                    ->numeric()
                    ->prefix('₽')
                    ->step(0.01)
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('ФИО')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->maxLength(255)
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->required(),
                Select::make('role')
                    ->label('Роль')
                    ->options(function ($record) {
                        $roles = \Spatie\Permission\Models\Role::whereNotIn('name', ['super_admin', 'panel_user'])
                            ->pluck('name', 'id');
                        // Если у пользователя есть роль, и она не входит в список (например, panel_user), добавляем её
                        if ($record && $record->roles->first()) {
                            $currentRole = $record->roles->first();
                            if (!$roles->has($currentRole->id)) {
                                $roles->put($currentRole->id, $currentRole->name);
                            }
                        }
                        return $roles;
                    })
                    ->required()
                    ->preload()
                    ->searchable()
                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->roles->first()?->id)),
            ]);
    }
}

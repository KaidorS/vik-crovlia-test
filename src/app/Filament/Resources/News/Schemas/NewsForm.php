<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(128)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Краткое описание')
                    ->required()
                    ->maxLength(1024)
                    ->rows(3)
                    ->columnSpanFull(),

                MarkdownEditor::make('content')
                    ->label('Полный контент (HTML)')
                    ->required()
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 'heading', 'bulletList', 'orderedList', 'codeBlock', 'blockquote', 'undo', 'redo'
                    ])
                    ->columnSpanFull(),

                TextInput::make('author')
                    ->label('Автор')
                    ->required()
                    ->maxLength(256)
                    ->default(fn() => auth()->user()?->name ?? '')
                    ->readOnly(fn() => !auth()->user()?->hasAnyRole(['super_admin', 'panel_user']))
                    ->dehydrated(true),
            ]);
    }
}

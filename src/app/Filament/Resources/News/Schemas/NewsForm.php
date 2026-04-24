<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        if (auth()->user()?->hasAnyRole(['super_admin', 'panel_user'])) {
            $authorField = Select::make('user_id')
                ->label('Автор')
                ->options(User::pluck('name', 'id'))
                ->required()
                ->searchable()
                ->preload();
        } else {
            $authorField = Hidden::make('user_id')
                ->default(auth()->id())
                ->required();
        }

        return $schema
            ->schema(array_merge(
                [$authorField],
                [
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

//                TextInput::make('author')
//                    ->label('Автор')
//                    ->required()
//                    ->maxLength(256)
//                    ->default(fn() => auth()->user()?->name ?? '')
//                    ->readOnly(fn() => !auth()->user()?->hasAnyRole(['super_admin', 'panel_user']))
//                    ->dehydrated(true),
            ]));
    }
}

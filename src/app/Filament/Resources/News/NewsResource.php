<?php

namespace App\Filament\Resources\News;

use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\News\Pages\EditNews;
use App\Filament\Resources\News\Pages\ListNews;
use App\Filament\Resources\News\Schemas\NewsForm;
use App\Filament\Resources\News\Tables\NewsTable;
use App\Models\News;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class NewsResource extends Resource
{
    protected static ?string $navigationLabel = 'Новости';

    protected static ?string $model = News::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
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
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('author')
                    ->label('Автор')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y H:i')
                    ->toggleable()
                    ->sortable(),
            ])
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->filters([
                SelectFilter::make('author')
                    ->label('Автор')
                    ->options(News::distinct('author')->pluck('author', 'author')->toArray()),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('С даты'),
                        DatePicker::make('to')->label('По дату'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['to'], fn($q) => $q->whereDate('created_at', '<=', $data['to']));
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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

    public static function getPages(): array
    {
        return [
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'edit' => EditNews::route('/{record}/edit'),
        ];
    }
}

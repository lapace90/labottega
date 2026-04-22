<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $modelLabel = 'Evento';
    protected static ?string $pluralModelLabel = 'Eventi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contenuti')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Titolo')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set, Forms\Get $get) {
                                // Auto-slug solo in creazione e solo per la locale IT
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(200)
                            ->helperText('Parte finale dell\'URL, es. /eventi/sagra-dell-olio'),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Riassunto')
                            ->maxLength(300)
                            ->rows(2)
                            ->helperText('Breve descrizione mostrata nelle anteprime e sui motori di ricerca (max 300 caratteri).'),

                        Forms\Components\RichEditor::make('description')
                            ->label('Descrizione')
                            ->toolbarButtons([
                                'bold', 'italic', 'link',
                                'bulletList', 'orderedList',
                                'undo', 'redo',
                            ]),

                        Forms\Components\TextInput::make('location_name')
                            ->label('Luogo')
                            ->maxLength(200)
                            ->placeholder('Es. Piazza San Michele, Montopoli in Val d\'Arno'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Informazioni evento')
                    ->schema([
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Inizio')
                            ->required()
                            ->seconds(false)
                            ->displayFormat('d/m/Y H:i'),

                        Forms\Components\DateTimePicker::make('ends_at')
                            ->label('Fine (opzionale)')
                            ->seconds(false)
                            ->displayFormat('d/m/Y H:i')
                            ->after('starts_at'),

                        Forms\Components\TextInput::make('organizer_name')
                            ->label('Organizzatore')
                            ->maxLength(200)
                            ->placeholder('Es. Comune di Montopoli in Val d\'Arno'),

                        Forms\Components\TextInput::make('external_url')
                            ->label('Link esterno (opzionale)')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://...')
                            ->helperText('Pagina ufficiale dell\'evento sul sito dell\'organizzatore.'),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Immagine di copertina')
                            ->image()
                            ->directory('events')
                            ->imageEditor()
                            ->maxSize(3072)
                            ->helperText('Formati: JPG, PNG, WebP. Max 3 MB.'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Pubblicato')
                            ->helperText('Se disattivato, l\'evento non è visibile sul sito pubblico.')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('')
                    ->height(50)
                    ->width(80),

                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Inizio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('organizer_name')
                    ->label('Organizzatore')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Pubblicato')
                    ->boolean(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Stato')
                    ->trueLabel('Pubblicati')
                    ->falseLabel('Bozze'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}

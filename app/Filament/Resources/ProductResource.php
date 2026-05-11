<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $modelLabel = 'Prodotto';
    protected static ?string $pluralModelLabel = 'Prodotti';

    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni base')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(200)
                            ->unique(table: 'products', ignorable: fn ($record) => $record)
                            ->helperText('URL del prodotto, es. /shop/prodotto/pane-sciocco'),

                        Forms\Components\Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Textarea::make('description')
                            ->label('Descrizione')
                            ->rows(3)
                            ->maxLength(500)
                            ->nullable(),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Foto prodotto')
                            ->image()
                            ->directory('products')
                            ->imageEditor()
                            ->maxSize(3072)
                            ->helperText('Formati: JPG, PNG, WebP. Max 3 MB.')
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Prezzo')
                    ->schema([
                        Forms\Components\Select::make('pricing_type')
                            ->label('Tipo di prezzo')
                            ->options([
                                'piece' => 'Al pezzo',
                                'weight' => 'Al peso',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('price_piece')
                            ->label('Prezzo al pezzo')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01)
                            ->minValue(0)
                            ->required(fn (Forms\Get $get) => $get('pricing_type') === 'piece')
                            ->visible(fn (Forms\Get $get) => $get('pricing_type') === 'piece'),

                        Forms\Components\TextInput::make('price_per_kg')
                            ->label('Prezzo al kg')
                            ->numeric()
                            ->prefix('€/kg')
                            ->step(0.01)
                            ->minValue(0)
                            ->required(fn (Forms\Get $get) => $get('pricing_type') === 'weight')
                            ->visible(fn (Forms\Get $get) => $get('pricing_type') === 'weight'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Grammature')
                    ->schema([
                        Forms\Components\Repeater::make('variants')
                            ->relationship('variants')
                            ->schema([
                                Forms\Components\TextInput::make('grams')
                                    ->label('Grammatura')
                                    ->numeric()
                                    ->required()
                                    ->suffix('g')
                                    ->minValue(1),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Ordine')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('Aggiungi grammatura')
                            ->columns(2),
                    ])
                    ->visible(fn (Forms\Get $get) => $get('pricing_type') === 'weight'),

                Forms\Components\Section::make('Visibilità')
                    ->schema([
                        Forms\Components\Toggle::make('is_available')
                            ->label('Disponibile')
                            ->default(true)
                            ->helperText('Se disattivato, il prodotto non sarà visibile sul sito pubblico'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Ordine')
                            ->numeric()
                            ->default(0)
                            ->helperText('Più basso = appare prima nella categoria'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('')
                    ->square()
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('pricing_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'piece' => 'Al pezzo',
                        'weight' => 'Al peso',
                        default => $state,
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('display_price')
                    ->label('Prezzo')
                    ->getStateUsing(fn (Product $record) => $record->displayPrice()),

                Tables\Columns\ToggleColumn::make('is_available')
                    ->label('Disponibile'),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name'),

                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Disponibilità')
                    ->trueLabel('Disponibili')
                    ->falseLabel('Non disponibili'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

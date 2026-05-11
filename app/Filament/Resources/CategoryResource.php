<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $modelLabel = 'Categoria';
    protected static ?string $pluralModelLabel = 'Categorie';

    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(100)
                            ->unique(table: 'categories', ignorable: fn ($record) => $record)
                            ->helperText('Identificatore URL della categoria, es. salumi'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Ordine')
                            ->numeric()
                            ->default(0)
                            ->helperText('Più basso = appare prima'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Attiva')
                            ->default(true)
                            ->helperText('Se disattivata, la categoria e i suoi prodotti non sono visibili sul sito'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(),

                Tables\Columns\TextInputColumn::make('sort_order')
                    ->label('Ordine')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Attiva'),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Prodotti')
                    ->counts('products')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([])
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

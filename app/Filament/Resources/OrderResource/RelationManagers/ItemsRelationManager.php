<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string  $relationship = 'items';
    protected static ?string $title        = 'Prodotti ordinati';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Prodotto'),

                Tables\Columns\TextColumn::make('display_quantity')
                    ->label('Quantità')
                    ->getStateUsing(fn ($record) => $record->display_quantity),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Prezzo unitario')
                    ->money('EUR'),

                Tables\Columns\TextColumn::make('line_total')
                    ->label('Totale riga')
                    ->money('EUR')
                    ->weight('bold'),
            ])
            ->paginated(false)
            ->heading('Prodotti ordinati');
    }

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function isReadOnly(): bool
    {
        return true;
    }
}

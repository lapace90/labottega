<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon  = 'heroicon-o-shopping-cart';
    protected static ?string $modelLabel      = 'Ordine';
    protected static ?string $pluralModelLabel = 'Ordini';
    protected static ?string $navigationGroup = 'E-commerce';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Stato ordine')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Stato')
                        ->options(Order::STATUSES)
                        ->required(),
                ]),

            Forms\Components\Section::make('Cliente')
                ->schema([
                    Forms\Components\TextInput::make('customer_name')->label('Nome')->disabled(),
                    Forms\Components\TextInput::make('customer_phone')->label('Telefono')->disabled(),
                    Forms\Components\TextInput::make('customer_email')->label('Email')->disabled(),
                    Forms\Components\Textarea::make('customer_notes')->label('Note')->disabled()->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Ordine')
                ->schema([
                    Forms\Components\TextInput::make('order_number')->label('Numero ordine')->disabled(),
                    Forms\Components\TextInput::make('type')->label('Tipo')->disabled(),
                    Forms\Components\DatePicker::make('slot_date')->label('Data ritiro')->disabled(),
                    Forms\Components\TextInput::make('slot_time_range')->label('Fascia oraria')->disabled(),
                    Forms\Components\TextInput::make('subtotal')->label('Subtotale')->disabled()->prefix('€'),
                    Forms\Components\TextInput::make('delivery_cost')->label('Costo consegna')->disabled()->prefix('€'),
                    Forms\Components\TextInput::make('total')->label('Totale')->disabled()->prefix('€'),
                ])->columns(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Stato')
                ->schema([
                    Infolists\Components\TextEntry::make('order_number')->label('Numero ordine')->weight('bold'),
                    Infolists\Components\TextEntry::make('status_label')->label('Stato'),
                    Infolists\Components\TextEntry::make('type_label')->label('Tipo'),
                    Infolists\Components\TextEntry::make('created_at')->label('Creato il')->dateTime('d/m/Y H:i'),
                ])->columns(2),

            Infolists\Components\Section::make('Cliente')
                ->schema([
                    Infolists\Components\TextEntry::make('customer_name')->label('Nome'),
                    Infolists\Components\TextEntry::make('customer_phone')->label('Telefono'),
                    Infolists\Components\TextEntry::make('customer_email')->label('Email')->default('—'),
                    Infolists\Components\TextEntry::make('customer_notes')->label('Note')->default('—')->columnSpanFull(),
                ])->columns(2),

            Infolists\Components\Section::make('Ritiro')
                ->schema([
                    Infolists\Components\TextEntry::make('slot_date')->label('Data')->date('d/m/Y'),
                    Infolists\Components\TextEntry::make('slot_time_range')->label('Fascia oraria'),
                ])->columns(2),

            Infolists\Components\Section::make('Totali')
                ->schema([
                    Infolists\Components\TextEntry::make('subtotal')->label('Subtotale')->money('EUR'),
                    Infolists\Components\TextEntry::make('delivery_cost')->label('Consegna')->money('EUR'),
                    Infolists\Components\TextEntry::make('total')->label('Totale')->money('EUR')->weight('bold'),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('N° ordine')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Telefono'),

                Tables\Columns\TextColumn::make('slot_date')
                    ->label('Data ritiro')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('slot_time_range')
                    ->label('Fascia'),

                Tables\Columns\TextColumn::make('total')
                    ->label('Totale')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stato')
                    ->formatStateUsing(fn ($state) => Order::STATUSES[$state] ?? $state)
                    ->colors([
                        'warning' => 'pending',
                        'primary' => fn ($state) => in_array($state, ['confirmed', 'preparing']),
                        'success' => fn ($state) => in_array($state, ['ready', 'picked_up', 'delivered']),
                        'danger'  => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('slot_date', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stato')
                    ->options(Order::STATUSES),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options(Order::TYPES),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

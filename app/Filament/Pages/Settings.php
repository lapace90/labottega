<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Impostazioni';
    protected static ?string $title = 'Impostazioni generali del sito';
    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'shop_enabled' => Setting::getBool('shop_enabled', false),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Shop online')
                    ->description('Quando lo shop è disattivato, i clienti vedranno una pagina "in arrivo" al posto del catalogo. Il bottone Shop sarà ancora visibile ma porterà a quella pagina.')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Toggle::make('shop_enabled')
                            ->label('Shop online attivo')
                            ->helperText('Attiva quando il catalogo è pronto e vuoi che i clienti possano comprare online.')
                            ->onColor('success')
                            ->offColor('warning'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salva impostazioni')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('shop_enabled', $data['shop_enabled'] ? '1' : '0');

        Notification::make()
            ->title('Impostazioni salvate')
            ->success()
            ->send();
    }
}

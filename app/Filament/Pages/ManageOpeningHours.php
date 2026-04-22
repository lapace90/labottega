<?php

namespace App\Filament\Pages;

use App\Models\OpeningHour;
use App\Models\SpecialClosing;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageOpeningHours extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Orari e chiusure';
    protected static ?string $title = 'Orari e chiusure';
    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.manage-opening-hours';

    public ?array $data = [];

    public function mount(): void
    {
        $weeklyData = [];
        foreach (OpeningHour::DAY_LABELS as $day => $label) {
            $slots = OpeningHour::forDay($day)->get()->map(fn($h) => [
                'opens_at' => \Carbon\Carbon::parse($h->opens_at)->format('H:i'),
                'closes_at' => \Carbon\Carbon::parse($h->closes_at)->format('H:i'),
            ])->toArray();

            $weeklyData["day_{$day}"] = $slots;
        }

        $closingsData = SpecialClosing::orderBy('starts_at')
            ->get()
            ->map(fn($c) => [
                'starts_at' => $c->starts_at->format('Y-m-d'),
                'ends_at' => $c->ends_at?->format('Y-m-d'),
                'reason' => $c->reason,
            ])->toArray();

        $this->form->fill([
            'weekly' => $weeklyData,
            'closings' => $closingsData,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('tabs')
                    ->tabs([
                        Tabs\Tab::make('Orari settimanali')
                            ->icon('heroicon-o-calendar-days')
                            ->schema($this->weeklySchema()),

                        Tabs\Tab::make('Chiusure straordinarie')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Repeater::make('closings')
                                    ->label('')
                                    ->schema([
                                        DatePicker::make('starts_at')
                                            ->label('Data inizio')
                                            ->required()
                                            ->native(false)
                                            ->displayFormat('d/m/Y'),
                                        DatePicker::make('ends_at')
                                            ->label('Data fine (lascia vuoto se è un solo giorno)')
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->after('starts_at'),
                                        TextInput::make('reason')
                                            ->label('Motivo')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Es. Natale, Ferie estive, Pasqua...'),
                                    ])
                                    ->columns(3)
                                    ->addActionLabel('Aggiungi chiusura')
                                    ->defaultItems(0)
                                    ->reorderable(false),
                            ]),
                    ])
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    protected function weeklySchema(): array
    {
        $sections = [];
        foreach (OpeningHour::DAY_LABELS as $day => $label) {
            $sections[] = Section::make($label)
                ->schema([
                    Repeater::make("weekly.day_{$day}")
                        ->label('')
                        ->schema([
                            TimePicker::make('opens_at')
                                ->label('Apertura')
                                ->required()
                                ->seconds(false)
                                ->displayFormat('H:i'),
                            TimePicker::make('closes_at')
                                ->label('Chiusura')
                                ->required()
                                ->seconds(false)
                                ->displayFormat('H:i')
                                ->after('opens_at'),
                        ])
                        ->columns(2)
                        ->addActionLabel('Aggiungi fascia oraria')
                        ->defaultItems(0)
                        ->reorderable(false),
                ])
                ->collapsible()
                ->collapsed(false);
        }

        return $sections;
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salva')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        OpeningHour::truncate();
        foreach (OpeningHour::DAY_LABELS as $day => $label) {
            $slots = $data['weekly']["day_{$day}"] ?? [];
            foreach ($slots as $i => $slot) {
                OpeningHour::create([
                    'day_of_week' => $day,
                    'opens_at' => $slot['opens_at'],
                    'closes_at' => $slot['closes_at'],
                    'sort_order' => $i + 1,
                ]);
            }
        }

        SpecialClosing::truncate();
        foreach ($data['closings'] ?? [] as $closing) {
            SpecialClosing::create([
                'starts_at' => $closing['starts_at'],
                'ends_at' => $closing['ends_at'] ?: null,
                'reason' => $closing['reason'],
            ]);
        }

        Notification::make()
            ->title('Orari salvati con successo')
            ->success()
            ->send();
    }
}

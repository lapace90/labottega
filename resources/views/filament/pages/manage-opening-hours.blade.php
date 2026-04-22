<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button
                type="submit"
                size="lg"
                wire:loading.attr="disabled"
                wire:target="save">
                <x-filament::loading-indicator
                    class="h-5 w-5"
                    wire:loading
                    wire:target="save" />
                <span wire:loading.remove wire:target="save">Salva orari</span>
                <span wire:loading wire:target="save">Salvataggio…</span>
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>

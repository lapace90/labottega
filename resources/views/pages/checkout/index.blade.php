@extends('layouts.app')

@section('title', 'Checkout — La Bottega del Gusto')

@section('content')
<section class="checkout-page">
    <div class="container">
        <h1 class="checkout-page__title">Completa il tuo ordine</h1>

        @if(session('error'))
            <div class="checkout-page__error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('checkout.submit') }}" method="POST" class="checkout-form">
            @csrf
            <input type="hidden" name="type" value="pickup">

            <div class="checkout-grid">

                {{-- Colonna sinistra: form --}}
                <div class="checkout-form__main">

                    {{-- Modalità ordine --}}
                    <fieldset class="checkout-section">
                        <legend>Modalità ordine</legend>
                        <div class="checkout-modes">
                            <label class="checkout-mode checkout-mode--active">
                                <input type="radio" name="mode" value="pickup" checked>
                                <div class="checkout-mode__content">
                                    <h3>Click &amp; Collect</h3>
                                    <p>Ritira l'ordine direttamente in bottega</p>
                                </div>
                            </label>
                            <label class="checkout-mode checkout-mode--disabled">
                                <input type="radio" name="mode" value="delivery" disabled>
                                <div class="checkout-mode__content">
                                    <h3>Consegna a domicilio <span class="checkout-mode__badge">In arrivo</span></h3>
                                    <p>{{ $deliveryPlaceholder }}</p>
                                </div>
                            </label>
                        </div>
                    </fieldset>

                    {{-- Slot ritiro --}}
                    <fieldset class="checkout-section">
                        <legend>Quando vuoi ritirare</legend>

                        @if(empty($pickupSlots))
                            <p class="checkout-section__notice">
                                Nessuna fascia di ritiro disponibile nei prossimi 7 giorni.
                                Contattaci su WhatsApp per organizzare il ritiro.
                            </p>
                        @else
                            <div class="checkout-field">
                                <label for="slot_date">Giorno</label>
                                <select name="slot_date" id="slot_date" required onchange="updateTimeSlots(this.value)">
                                    <option value="">Seleziona un giorno</option>
                                    @foreach($pickupSlots as $day)
                                        <option value="{{ $day['date'] }}"
                                                data-slots='@json($day['slots'])'>
                                            {{ ucfirst($day['date_label']) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('slot_date')
                                    <span class="checkout-field__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="checkout-field">
                                <label for="slot_time_range">Fascia oraria</label>
                                <select name="slot_time_range" id="slot_time_range" required disabled>
                                    <option value="">Prima seleziona un giorno</option>
                                </select>
                                @error('slot_time_range')
                                    <span class="checkout-field__error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </fieldset>

                    {{-- Dati cliente --}}
                    <fieldset class="checkout-section">
                        <legend>I tuoi dati</legend>

                        <div class="checkout-field">
                            <label for="customer_name">Nome e cognome *</label>
                            <input type="text" name="customer_name" id="customer_name"
                                   value="{{ old('customer_name') }}" required maxlength="100">
                            @error('customer_name')
                                <span class="checkout-field__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="checkout-field">
                            <label for="customer_phone">Telefono *</label>
                            <input type="tel" name="customer_phone" id="customer_phone"
                                   value="{{ old('customer_phone') }}" required maxlength="30"
                                   placeholder="es. 392 1234567">
                            @error('customer_phone')
                                <span class="checkout-field__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="checkout-field">
                            <label for="customer_email">Email (opzionale)</label>
                            <input type="email" name="customer_email" id="customer_email"
                                   value="{{ old('customer_email') }}" maxlength="150"
                                   placeholder="per ricevere conferma">
                            @error('customer_email')
                                <span class="checkout-field__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="checkout-field">
                            <label for="customer_notes">Note (opzionale)</label>
                            <textarea name="customer_notes" id="customer_notes"
                                      maxlength="500" rows="3"
                                      placeholder="Es. allergie, preferenze, info aggiuntive">{{ old('customer_notes') }}</textarea>
                            @error('customer_notes')
                                <span class="checkout-field__error">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                {{-- Colonna destra: riepilogo --}}
                <aside class="checkout-summary">
                    <h2 class="checkout-summary__title">Riepilogo ordine</h2>

                    <ul class="checkout-summary__items">
                        @foreach($items as $item)
                            <li class="checkout-summary__item">
                                <div>
                                    <strong>{{ $item['product_name'] }}</strong>
                                    <span class="checkout-summary__item-qty">{{ $item['display_quantity'] }}</span>
                                </div>
                                <span>{{ number_format($item['line_total'], 2, ',', '.') }} €</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="checkout-summary__totals">
                        <div class="checkout-summary__row">
                            <span>Subtotale</span>
                            <span>{{ number_format($subtotal, 2, ',', '.') }} €</span>
                        </div>
                        <div class="checkout-summary__row">
                            <span>Ritiro in bottega</span>
                            <span>Gratuito</span>
                        </div>
                        <div class="checkout-summary__row checkout-summary__row--total">
                            <strong>Totale</strong>
                            <strong>{{ number_format($subtotal, 2, ',', '.') }} €</strong>
                        </div>
                    </div>

                    <button type="submit" class="checkout-submit-btn" @if(empty($pickupSlots)) disabled @endif>
                        Conferma ordine
                    </button>

                    <p class="checkout-summary__notice">
                        Confermando l'ordine ti reindirizzeremo su WhatsApp per inviare la conferma alla bottega.
                        Pagherai al ritiro.
                    </p>
                </aside>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
function updateTimeSlots(date) {
    var timeSelect = document.getElementById('slot_time_range');
    var daySelect  = document.getElementById('slot_date');

    if (!date) {
        timeSelect.innerHTML = '<option value="">Prima seleziona un giorno</option>';
        timeSelect.disabled  = true;
        return;
    }

    var selectedOption = daySelect.options[daySelect.selectedIndex];
    var slots = JSON.parse(selectedOption.dataset.slots || '[]');

    timeSelect.innerHTML = '<option value="">Seleziona una fascia oraria</option>';
    slots.forEach(function (slot) {
        var opt       = document.createElement('option');
        opt.value     = slot.time_range;
        opt.textContent = slot.opens_at + ' - ' + slot.closes_at;
        timeSelect.appendChild(opt);
    });
    timeSelect.disabled = false;
}
</script>
@endpush
@endsection

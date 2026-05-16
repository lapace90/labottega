<?php

namespace App\Services;

use App\Models\OpeningHour;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SpecialClosing;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(protected CartService $cart) {}

    public function availablePickupSlots(): array
    {
        $daysAhead       = config('delivery.pickup.days_ahead', 7);
        $minHoursAdvance = config('delivery.pickup.min_hours_advance', 2);

        $now  = Carbon::now('Europe/Rome');
        $slots = [];

        $closings = SpecialClosing::where('starts_at', '<=', $now->copy()->addDays($daysAhead)->toDateString())
            ->where(function ($q) use ($now) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', $now->toDateString());
            })
            ->get();

        for ($i = 0; $i < $daysAhead; $i++) {
            $date      = $now->copy()->addDays($i)->startOfDay();
            $dateStr   = $date->toDateString();
            $dayOfWeek = $date->dayOfWeekIso - 1; // 0=Lun … 6=Dom

            $isClosed = $closings->contains(function ($c) use ($dateStr) {
                $end = ($c->ends_at ?? $c->starts_at)->toDateString();
                return $dateStr >= $c->starts_at->toDateString() && $dateStr <= $end;
            });
            if ($isClosed) continue;

            $hours = OpeningHour::forDay($dayOfWeek)->get();
            if ($hours->isEmpty()) continue;

            $daySlots = [];
            foreach ($hours as $h) {
                $openTime  = $date->copy()->setTimeFromTimeString($h->opens_at->format('H:i'));
                $closeTime = $date->copy()->setTimeFromTimeString($h->closes_at->format('H:i'));

                if ($openTime->copy()->subHours($minHoursAdvance)->isPast()) continue;

                $daySlots[] = [
                    'time_range' => $openTime->format('H:i') . '-' . $closeTime->format('H:i'),
                    'opens_at'   => $openTime->format('H:i'),
                    'closes_at'  => $closeTime->format('H:i'),
                ];
            }

            if (empty($daySlots)) continue;

            $slots[] = [
                'date'       => $dateStr,
                'date_label' => $date->locale('it')->isoFormat('dddd D MMMM'),
                'slots'      => $daySlots,
            ];
        }

        return $slots;
    }

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $items = $this->cart->getItems();

            if ($items->isEmpty()) {
                throw new \RuntimeException('Carrello vuoto');
            }

            $subtotal     = $this->cart->subtotal();
            $deliveryCost = 0;
            $total        = $subtotal + $deliveryCost;

            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'customer_name'  => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'customer_notes' => $data['customer_notes'] ?? null,
                'type'           => 'pickup',
                'slot_date'      => $data['slot_date'],
                'slot_time_range' => $data['slot_time_range'],
                'subtotal'       => $subtotal,
                'delivery_cost'  => $deliveryCost,
                'total'          => $total,
                'status'         => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'product_name'  => $item['product_name'],
                    'product_slug'  => $item['product_slug'],
                    'pricing_type'  => $item['pricing_type'],
                    'variant_grams' => $item['variant_grams'] ?? null,
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $item['unit_price'],
                    'line_total'    => $item['line_total'],
                ]);
            }

            $this->cart->clear();

            return $order;
        });
    }

    public function whatsappMessage(Order $order): string
    {
        $itemsText = $order->items->map(function ($item) {
            return "• {$item->display_quantity} {$item->product_name}";
        })->implode("\n");

        $slotDate = $order->slot_date->locale('it')->isoFormat('dddd D MMMM');

        $msg  = "Ciao! Ho appena fatto l'ordine *{$order->order_number}* sul vostro sito.\n\n";
        $msg .= "*Tipo*: Click & Collect (ritiro in bottega)\n";
        $msg .= "*Ritiro*: {$slotDate}, ore {$order->slot_time_range}\n\n";
        $msg .= "*Prodotti*:\n{$itemsText}\n\n";
        $msg .= "*Totale*: " . number_format((float) $order->total, 2, ',', '.') . " €\n\n";

        if ($order->customer_notes) {
            $msg .= "*Note*: {$order->customer_notes}\n\n";
        }

        $msg .= 'Grazie!';

        return $msg;
    }
}

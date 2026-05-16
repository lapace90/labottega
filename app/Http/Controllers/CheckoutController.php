<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cart,
        protected CheckoutService $checkout,
    ) {}

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('shop.index')
                ->with('error', 'Il tuo carrello è vuoto.');
        }

        return view('pages.checkout.index', [
            'items'               => $this->cart->getItems(),
            'subtotal'            => $this->cart->subtotal(),
            'pickupSlots'         => $this->checkout->availablePickupSlots(),
            'deliveryEnabled'     => config('delivery.modes.delivery.enabled'),
            'deliveryPlaceholder' => config('delivery.modes.delivery.placeholder_message'),
        ]);
    }

    public function submit(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('shop.index')
                ->with('error', 'Il tuo carrello è vuoto.');
        }

        $data = $request->validate([
            'customer_name'   => 'required|string|max:100',
            'customer_phone'  => 'required|string|max:30',
            'customer_email'  => 'nullable|email|max:150',
            'customer_notes'  => 'nullable|string|max:500',
            'slot_date'       => 'required|date|after_or_equal:today',
            'slot_time_range' => 'required|string|max:20',
            'type'            => 'required|in:pickup',
        ]);

        try {
            $order = $this->checkout->createOrder($data);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Errore creazione ordine: ' . $e->getMessage());
        }

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        $message      = $this->checkout->whatsappMessage($order);
        $whatsappUrl  = 'https://wa.me/' . config('delivery.whatsapp_number') . '?text=' . urlencode($message);

        return view('pages.checkout.success', [
            'order'        => $order,
            'whatsappUrl'  => $whatsappUrl,
        ]);
    }
}

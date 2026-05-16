<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name', 'customer_phone', 'customer_email', 'customer_notes',
        'type',
        'slot_date', 'slot_time_range',
        'delivery_address', 'delivery_zone',
        'subtotal', 'delivery_cost', 'total',
        'status',
    ];

    protected $casts = [
        'slot_date'     => 'date',
        'subtotal'      => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    public const STATUSES = [
        'pending'    => 'In attesa',
        'confirmed'  => 'Confermato',
        'preparing'  => 'In preparazione',
        'ready'      => 'Pronto',
        'picked_up'  => 'Ritirato',
        'delivered'  => 'Consegnato',
        'cancelled'  => 'Annullato',
    ];

    public const TYPES = [
        'pickup'   => 'Click & Collect',
        'delivery' => 'Consegna a domicilio',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        // Per ora: sempre "DA PAGARE AL RITIRO" (no Stripe attivo)
        // Quando Sprint 3 aggiungerà Stripe, qui controlleremo $this->payment_status
        return 'DA PAGARE AL RITIRO';
    }

    public static function generateOrderNumber(): string
    {
        $year = now()->format('Y');
        $latest = self::where('order_number', 'like', "LB-{$year}-%")
            ->orderByDesc('id')
            ->value('order_number');

        $next = $latest ? ((int) substr($latest, -4)) + 1 : 1;

        return sprintf('LB-%s-%04d', $year, $next);
    }
}

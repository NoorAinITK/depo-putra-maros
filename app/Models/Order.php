<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'customer_name', 'source', 'order_type', 'qty', 'price', 'total',
        'service_method', 'payment_method', 'payment_status', 'process_status', 'scheduled_at',
    ];

    protected function casts(): array
    {
        return ['scheduled_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Order::hariIni() -> pesanan yang jadwalnya (atau dibuatnya) hari ini
    public function scopeHariIni(Builder $query): Builder
    {
        return $query->where(function ($w) {
            $w->whereDate('scheduled_at', today())
              ->orWhere(fn ($x) => $x->whereNull('scheduled_at')->whereDate('created_at', today()));
        });
    }

    // $order->waktu -> jam ambil kalau ada, kalau tidak jam dibuat
    public function getWaktuAttribute()
    {
        return $this->scheduled_at ?? $this->created_at;
    }
}

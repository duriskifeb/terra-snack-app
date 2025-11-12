<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'packaging_fee_per_item',
        'packaging_fee_total',
        'total_price',
        'status',
        'gateway_ref',
        'gross_amount',
        'payment_status',
        'payment_method',
        'payment_proof', 
        'paid_at',      
    ];

    protected $casts = [
        'packaging_fee_per_item' => 'decimal:2',
        'packaging_fee_total' => 'decimal:2',
        'total_price' => 'decimal:2',
        'gross_amount' => 'decimal:2',
        'status' => 'string',
        'payment_status' => 'string',
        'paid_at' => 'datetime', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

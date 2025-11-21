<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OptionValue extends Model
{
    protected $fillable = [
        'customization_option_id',
        'name',
        'details',
        'price_modifier',
    ];

    protected $casts = [
        'price_modifier' => 'decimal:2',
         'details' => 'array',
    ];

    public function customizationOption(): BelongsTo
    {
        return $this->belongsTo(CustomizationOption::class);
    }

    public function orderItems(): BelongsToMany
    {
        return $this->belongsToMany(OrderItem::class, 'order_item_option_values');
    }
}

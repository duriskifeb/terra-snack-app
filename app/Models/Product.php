<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'description',
        'image_url'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function customizationOptions(): BelongsToMany
    {
        return $this->belongsToMany(CustomizationOption::class, 'product_customizable_options');

    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}

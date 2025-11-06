<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomizationOption extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_customizable_options');
    }

    public function optionValues(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }
}

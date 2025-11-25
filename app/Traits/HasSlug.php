<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    public function generateSlug()
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        }
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reports extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type', 
        'start_date',
        'end_date',
        'parameters',
        'status',
        'file_path',
        'generated_by'
    ];

    protected $casts = [
        'parameters' => 'array',
    ];
}
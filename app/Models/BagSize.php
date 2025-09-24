<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagSize extends Model
{
    protected $fillable = [
        'name',
        'weight',
        'price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('weight');
    }
}

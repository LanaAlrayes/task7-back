<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'price',
        'colors',
        'gear_type',
        'year',
    ];

    public function brand(): BelongsTo
    {
        return  $this->belongsTo(Brand::class);
    }

}

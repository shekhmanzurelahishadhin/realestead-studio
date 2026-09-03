<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'title', 'location', 'price', 'price_label', 'area',
        'bedrooms', 'bathrooms', 'status', 'image', 'gallery', 'amenities', 'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'amenities' => 'array',
        'price' => 'integer',
        'area' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
    ];
}

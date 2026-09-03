<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'location', 'category', 'year',
        'description', 'image', 'gallery', 'stats', 'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'stats' => 'array',
    ];
}

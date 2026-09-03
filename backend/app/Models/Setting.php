<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name', 'tagline', 'logo_image', 'favicon',
        'hero_image', 'hero_video', 'phone', 'email', 'address',
        'instagram_url', 'linkedin_url', 'facebook_url',
    ];

    /** There is always exactly one settings row. */
    public static function current(): self
    {
        return static::firstOrFail();
    }
}

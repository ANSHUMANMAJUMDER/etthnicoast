<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $fillable = [
        'slug', 'hero_title', 'hero_subtitle', 'hero_tag', 'hero_image',
        'sections', 'stats', 'cta_title', 'cta_subtitle',
        'cta_button_text', 'cta_button_url',
    ];

    protected $casts = [
        'sections' => 'array',
        'stats'    => 'array',
    ];

    public static function findBySlug(string $slug): self
    {
        return self::firstOrCreate(['slug' => $slug]);
    }
}

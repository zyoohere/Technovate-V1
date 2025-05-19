<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Artikel;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
    ];

    public function artikels()
    {
        return $this->belongsToMany(Artikel::class);
    }

     public function scopeSearch($query, $term)
    {
        return $query->where('nama', 'like', "%{$term}%")
                     ->orWhere('slug', 'like', "%{$term}%");
    }

    protected static function booted()
    {
        static::saving(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->nama);
            }
        });
    }
}

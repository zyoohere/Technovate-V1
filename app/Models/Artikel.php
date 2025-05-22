<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'status',
        'view_count',
        'published_at',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    //URL PENYIMPANAN
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
    public function getShortExcerptAttribute()
    {
        return str()->limit(strip_tags($this->excerpt), 100);
    }


    // app/Models/Artikel.php
    public function views()
    {
        return $this->hasMany(ArtikelView::class);
    }
    public static function boot()
{
    parent::boot();

    static::saving(function ($artikel) {
        if (empty($artikel->excerpt) && !empty($artikel->content)) {
            $artikel->excerpt = Str::words(strip_tags($artikel->content), 30);
        }
    });
}
}

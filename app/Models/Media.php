<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'artikel_id',
        'title',
        'caption',
        'type',
        'media_path',
        'media_url',
        'is_featured',
        'uploaded_by',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

      public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

       public function getFullUrlAttribute()
    {
        return $this->url ?? asset('storage/' . $this->filename);
    }

       public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

      public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'slug',
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];
    
    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    // RELASI KATEGORI MEMILIKI SUBKATEGORI(CHILDREN)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}

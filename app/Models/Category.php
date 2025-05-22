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
    ];
    
    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }
    

}

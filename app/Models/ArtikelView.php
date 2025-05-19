<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'artikel_id',
        'user_id',
        'ip_address',
        'viewed_at',
    ];

    public function artikel(){
        return $this->belongsTo(Artikel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

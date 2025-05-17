<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'artikel_id',
        'parent_id',
        'guest_name',
        'content',
        'status',
        'ip_address',
    ];

    protected $casts =[
        'parent_id' => 'integer',
        'status' => 'string',
    ];

    
        public function user(){
            return $this->belongsTo(User::class);
        }
    
        public function artikel(){
            return $this->belongsTo(Artikel::class);
        }
    
        public function parent(){
            return $this->belongsTo(Comment::class, 'parent_id');
        }
        public function replies(){
            return $this->hasMany(Comment::class, 'parent_id');
        }
        public function scopeApproved($query){
            return $query->where('status', 'approved');
        }
}

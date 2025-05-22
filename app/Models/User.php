<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';
    const ROLE_EDITOR = 'editor';
    const ROLE_GUEST = 'guest';
    const ROLE_SUBSCRIBER = 'subscriber';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
        'profil_pic',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isAuthor()
    {
        return $this->role === self::ROLE_AUTHOR;
    }
    public function isEditor()
    {
        return $this->role === self::ROLE_EDITOR;
    }
    public function isGuest()
    {
        return $this->role === self::ROLE_GUEST;
    }
    public function isSubscriber()
    {
        return $this->role === self::ROLE_SUBSCRIBER;
    }
    public function isActive(): bool
    {
        return $this->status === true;
    }



    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }
}

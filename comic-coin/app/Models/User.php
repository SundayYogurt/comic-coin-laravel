<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    const ROLE_USER = 'user';
    const ROLE_TRANSLATOR = 'translator';
    const ROLE_ADMIN = 'admin';

    protected $fillable = ['name', 'email', 'password', 'coins', 'role', 'is_admin'];
    protected $hidden = ['password'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function favoriteComics()
    {
        return $this->belongsToMany(Comic::class, 'comic_user');
    }

    public function comics()
    {
        return $this->hasMany(Comic::class, 'uploader_id');
    }

    public function isAdmin()
    {
        return $this->is_admin || $this->role === self::ROLE_ADMIN;
    }

    public function isTranslator()
    {
        return $this->role === self::ROLE_TRANSLATOR;
    }
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'coins'];
    protected $hidden = ['password'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function favoriteComics()
    {
        return $this->belongsToMany(Comic::class, 'comic_user');
    }
}

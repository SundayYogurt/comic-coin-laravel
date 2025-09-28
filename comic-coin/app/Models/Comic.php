<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model {
    protected $fillable = ['title', 'description', 'cover_image'];
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'comic_user');
    }
}

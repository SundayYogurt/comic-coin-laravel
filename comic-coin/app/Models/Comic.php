<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model {
    protected $fillable = ['title', 'description', 'cover_image', 'uploader_id', 'author'];
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'comic_user');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}

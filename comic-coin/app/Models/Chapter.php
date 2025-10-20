<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['comic_id', 'title', 'description', 'price', 'chapter_number'];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // เพิ่ม relation กับ Page
    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('page_number'); // เรียงตาม page_number
    }
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->latest();
    }
}

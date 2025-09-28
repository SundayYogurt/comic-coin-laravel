<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // กำหนดว่าคอลัมน์อะไรบ้างที่สามารถ mass assign ได้
    protected $fillable = [
        'user_id',
        'chapter_id',
        'amount',
    ];

    // ความสัมพันธ์กับ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ความสัมพันธ์กับ Chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}

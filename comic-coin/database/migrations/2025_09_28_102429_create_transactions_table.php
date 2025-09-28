<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');      // เชื่อมกับ users
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');   // เชื่อมกับ chapters
            $table->integer('amount')->default(0);                                   // จำนวนเหรียญ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

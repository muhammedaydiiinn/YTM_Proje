<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('player_view_counts', function (Blueprint $table) {
            $table->id();
            $table->string('player_id')->unique();  // Oyuncu ID'si
            $table->unsignedBigInteger('view_count')->default(0); // Görüntülenme sayısı
            $table->unsignedBigInteger('weekly_view_count')->default(0); // Haftalık görüntülenme sayısı
            $table->string('image_url')->nullable(); // Oyuncunun resim URL'si
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_view_counts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kullanıcı ID
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade'); // Futbolcu ID
            $table->timestamps();

            // Tekrar beğeniyi engellemek için bir unique constraint
            $table->unique(['user_id', 'player_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};

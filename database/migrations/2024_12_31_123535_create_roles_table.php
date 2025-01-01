<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // DB Facade kullanımı

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('role_id')->comment('1: admin, 2: scout, 3: user');
        });

        // Tablo oluşturulduktan sonra veri eklemek
        DB::table('roles')->insert([
            ['name' => 'admin', 'role_id' => 1],
            ['name' => 'scout', 'role_id' => 2],
            ['name' => 'user', 'role_id' => 3],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

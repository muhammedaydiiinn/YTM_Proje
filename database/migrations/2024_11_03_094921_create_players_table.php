<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the players collection
        Schema::connection('mongodb')->create('players', function ($collection) {
            $collection->index('_id'); // Index for the ObjectId
            $collection->string('achievements')->nullable();
            $collection->string('injuries')->nullable();
            $collection->string('jersey_numbers')->nullable();
            $collection->string('market_value')->nullable();
            $collection->json('profile')->nullable(); // JSON-like structure for profile
            $collection->json('stats')->nullable();
            $collection->json('transfers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

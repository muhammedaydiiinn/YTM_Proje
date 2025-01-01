<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $connection = 'mongodb'; // MongoDB kullanıyoruz

    protected $fillable = ['user_id', 'player_id'];

    // İlişki tanımlamaları
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function player()
    {
        return $this->belongsTo(Players::class);
    }
}

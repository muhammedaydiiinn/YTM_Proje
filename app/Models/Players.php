<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Players extends Model

{
    use HasFactory;
    protected $connection = 'mongodb';

    // Specify the collection name
    protected $collection = 'players';

    // Define the fields that can be mass assigned
    protected $fillable = [
        '_id',
        'achievements',
        'injuries',
        'jersey_numbers',
        'market_value',
        'profile',
        'stats',
        'transfers'
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}

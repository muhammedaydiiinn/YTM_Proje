<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class PlayerViewCount extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    // Specify the collection name
    protected $collection = 'player_view_counts';
    protected $fillable = ['player_id', 'view_count', 'image_url'];

    protected $casts = [
        'view_count' => 'integer',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class TopPlayerImage extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $collection = 'top_player_images';

    protected $fillable = ['image_url'];
}

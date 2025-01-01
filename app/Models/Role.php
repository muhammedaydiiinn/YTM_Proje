<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Doldurulabilir alanlar
    protected $collection = 'roles'; // MongoDB koleksiyon adı
    protected $connection = 'mongodb'; // MongoDB bağlantısı
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

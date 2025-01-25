<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Inversement on pourrait récupérer tous les articles appartenant à une même catégorie
    public function posts()
    {
        //Contrairement à belongsTO, cela veux dire que chaque catégorie, peut avoir plusieurs articles
        return $this ->hasMany(Post::class);
    }
}

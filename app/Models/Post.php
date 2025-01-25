<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory;

    // Permet de definir les champs qui sont remplissables vu qu'en laravel on ne peut pas exemple créer des articles directement dans le code
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'image'
    ];
    /**
    * category() permet à un objet Post d'accéder à la catégorie à laquelle il est associé. Cela facilite la récupération des informations de catégorie d'un post particulier
    **/
    public function category (){
        return $this -> belongsTo(Category::class);
    }

    /** Nous avons à faire à une relation (n - n)
     * Cela permet à un article d'avoir plusieurs tags
     * On pourrait aussi faire la même chose au niveau des tags pour inverser la relation
     * */
    public function tags () {
        return $this ->belongsToMany(Tag::class);
    }
    
    /**
     * imageUrl permet d'avoir dynamiquement le chémin de l'enplacement des fichiers image
     *
     * @return string|null
     */
    public function imageUrl() {
        /**Il est important de préciser, le disk que nous utilisons, voir le fichier config/filesystem.php
         * Et aussi dans le fichier .env, rajouter le bon chemin devant APP_URL de la sorte APP_URL=http://localhost:8000
         */
        return Storage::disk('public')->url($this->image); // 
    }


    // Permet de definir les champs qui ne sont pas remplissables
    protected $guarded = [];
}

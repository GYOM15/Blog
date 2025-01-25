<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Page d'authentification 
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'doLogin']);
// la fonction delete permet de se deconnecter, elle est prise en charge par laravel
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');




Route::prefix('/blog') ->name('blog.')->controller(BlogController::class)-> group(function(){
    //En prenant la notion de controller en compte, on a
    Route::get('/','index')->name('index');
    Route::get('/new','create')->name('create')->middleware('auth');// Nous utilisons le middleware auth dans Kernel.php pour vérifier que l'utilisateur soit authentifier avant accès
    Route::post('/new','store');
    Route::get('/{post}/edit', 'edit')->name('edit')->middleware('auth');
    Route::patch('/{post}/edit', 'update')->middleware('auth');
    /*Les accolades permettent de créer des paramètre dynamiques
       La clause where permet d'identifier lors de la recupération des variables dans le navigateur
       quel type doit prendre l'id et le slug dans le navigateur
    */

    //Route::get('/{slug}-{id}', function (string $slug, string $id, Request $request){
        /* Si le nom de la page est mal écrit dans le navigateur et l'id est passé, pour pouvoir récupérer la bonne page, on peut faire comme suit;
         *$post = Post::findOrFail($id);
            return $post;
         * Mais dans ce cas, le slug nous servirait à rien
         * Si on doit tenir compte du slug, il va falloir procéder de la sorte
         * *
        $post = Post::findOrFail($id);

        if($post->slug!=$slug){
            return to_route('blog.show', ['slug'=> $post->slug, 'id' => $post->id]);
        }
        return $post;
    */
//Route::get('/{slug}-{id}', function (string $slug, string $id, Request $request){
        /*return [
            'slug'=> $slug,
            'id' => $id,
            'name' => $request->input('name')
        ];

    Si on prend la notion de controller en compte, on aura
    Route::get('/{slug}-{post}','show')->where([
        En haut on remplace id par post qui contiendra tout ce qui conrespond à l'article
            'post' => '[0-9]+',
            'slug' => '[a-z0-9\-]+'
        ]
    )->name('show');*/
    Route::get('/{slug}-{post}','show')->where([
            'post' => '[0-9]+',
            'slug' => '[a-z0-9\-]+'
        ]
    )->name('show');
});


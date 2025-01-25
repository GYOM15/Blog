<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FormPostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Pagination\Paginator;


class BlogController extends Controller
{

    public function create() : View
    {
        // La création de cet objet post vide nous permet de gérer l'utilisation d'un seul formulaire pour la création et l'édition
        $post = new Post();
        //On peut préremplir ce champ en faisant
        //$post -> title = 'Bonjour';
        return view('blog.create', [
            'post' => $post,
            'categories' => Category::select('id', 'name') -> get(),
            'tags' => Tag::select('id', 'name') -> get()
        ]);
    }
    

    //Permet de vérifier et de stocker les informations
    public function store(FormPostRequest $request) : RedirectResponse
    {
      
        $post = Post::create($this->extractData(new Post(), $request));
        /**En synchronisant les tags, nous nous assurons que les tags associés à l'article correspondent exactement à ceux sélectionnés par l'utilisateur dans le formulaire.
         * Cela évite les incohérences dans les données de notre application. */
        $post->tags()->sync($request->validated('tags'));
        return redirect() -> route('blog.show', [
            'slug' => $post ->slug,
            'post'=> $post ->id
        ]) -> with('success', 'Larticle a bien été sauvegarder');
    }

    //Permet d'éditer un article
    public function edit(Post $post){
        return view('blog.edit', [
            'post' => $post,
            'categories' => Category::select('id', 'name') -> get(),
            'tags' => Tag::select('id', 'name') -> get()
        ]);
    }

    //
    public function update(Post $post, FormPostRequest $request){
        
        $post->update($this->extractData($post, $request));
        $post->tags()->sync($request->validated('tags'));
        return redirect() -> route('blog.show', [
            'slug' => $post ->slug,
            'post'=> $post ->id
        ]) -> with('success', 'Larticle a bien été modifié');

    }

    // Function permettant la vérification et l'extraction des datas
    private function extractData(Post $post, FormRequest $request) : array{
        $data = $request ->validated();
        /**@var UploadedFile $image */
        $image = $request->validated('image');
        // On vérifie si l'image est null ou si error on retourne simplement les données 
        if($image === null || $image->getError()){
            return $data;
        }
        //Vérification d'existance d'une image afin de la supprimer
        if($post->image){
            Storage::disk('public')->delete($post->image);
        }
        // sinon on stock l'image et on retourne toutes les données avec l'image
        $data['image'] = $image->store('blog', 'public');
        return $data;
        // Après avoir fait cela, on tape php artisan storage:link afin de creer une copie du dossier storage dans le dos public

    }


    // Correspondra à la page d'accueil de nos articles
    public function index(/*BlogFilterRequest $request*/): View{
        //dd($request->validated()); la méthode validated() permet de récupérer les données validées ou de valider arbitrairement en dehors du contexte d'une réquête
        /* Tout en haut on inject BlogFilterRequest pour définir nos propres règles de validation
        Valider les informations
        $validator = Validator::make([
            'title' => ''
        ], [
            'title' => 'required|min:8|max:7,2' // ou on peut faire [Rule::unique('posts')->ignore(2)] ou ['unique:posts]
        ]);
        dd($validator->validated()); //
        */
        /** On recupère chaque article avec sa catégorie
         * $posts= Post::with('categories')->get(); // Cela recupère chaque article avec sa categorie dynamiquement. ou on utilise:
        $posts= Post::all();
        */
        /**Dans cet exemple ci-dessous, on inverse la relation et recuperons les articles à partir des catégories
         * On crée d'abord les catégories
         * Category::create([
         * 'name' => 'Catégorie 3'
         * ]);
         * Category::create([
         * 'name' => 'Catégorie 4'
         * ]);
         * Dans ce cas ci, on récupère une catégorie et ensuite les articles contenus
         * $category = Category::find(2);
         * $post = Post::find(5);
         * $category->posts()->where('id', '>' ,'1')->get();  Un système de querybuilder
         * Si on va associer ou dissocier une catégorie à notre article 10
         * $post->category()->associate($category);
         * $post ->save(); **/

         /** Pour creer des tags on fait:
         * $post = Post::find(1);
         * $post->tags->createMany([[
         * 'name' => 'Tag 1'
         * ],[
         * 'name' => 'Tag 2'
         * ]]);
         * On peut aussi récupérer tous les articles qui ont des tags et même conditionner la récupération de la sorte
         * Post::has('tags', '>=', 1); // Récupère tous les articles qui ont au moins un tag
        */

        /**Création de tags
         *
         * $post = Post::find(2);
         * On peut attacher et détacher un tag, via 3 methodes,
         * attach, detach: $tags = $post ->tags() ->attach(id)
         * sync prend un tableau en paramètre; si le tableau est vide alors il va complètement détacher tous les tags
         * À la différence de sync et attach, quand on fait sync deux fois avec pour param les mêmes infos, au lieu de déclencher une érreur, il ne fait rien.
         * Si un article, detient 2 tags et qu'on passe un seul paramètre au sync, il supprimera le 2 eme tag et conservera ou attachera celui passé en paramètre

        $tags =$post ->tags()->sync([1,2]); // Permet de suprimer tous les tags
        * */

        /* Creation d'un utilisateur
        $user = User::create([
            'name' => 'John',
            'email' => 'john@doe.com',
            'password' => Hash::make('0000')
        ]);
        
        Pour savoir si l'utilisateur est connecté, on peut utiliser cette méthode
        dd(Auth::user());
        **/
        

        //On accède à la db par post vu que c'est le model
        return view('blog.index', [
            // Cela crée une variable $posts qui contiendra toutes la collection d'articles
            'posts' => Post::with('tags', 'category')->paginate(10)
        ]);
    }

    /**
     * @param string $slug
     * @param Post $post
     * @return RedirectResponse|View
     * Nous remplaçons int id par Post $post afin de récupérer dynamiquement toutes les informations qui correspondent à l'article)
     */
    public function show(string $slug, Post $post) : RedirectResponse | View {
        // On recupère les données de l'id correspondant
        //$post = Post::findOrFail($id);
        //dd($post);
        if($post->slug!=$slug){
            return to_route('blog.show', ['slug'=> $post->slug, 'post' => $post->id]);
        }
        // Toute fois retourner l'article qui correspond
        return View('blog.show', [
           'post' => $post
        ]);
    }
}

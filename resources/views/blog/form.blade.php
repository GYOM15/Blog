<!-- Cela étend de notre fichier base.blade.php -->
@extends('base')

@section('title', 'Modifier un article')


@section('content')

    <form action="" method="post" enctype="multipart/form-data">
        
        @csrf

        <!-- Utilisation de method pour spécifier la méthode HTTP en fonction de l'existence de l'ID du post -->
        <!-- Si l'ID du post existe, utilise la méthode PATCH pour mettre à jour le post -->
        <!-- Si l'ID du post n'existe pas, utilise la méthode POST pour créer un nouveau post -->
    
        @method($post->id ? "PATCH" : "POST")
        <!-- champ file -->
        <div class="form-group">
            <label for="image">Titre</label>
            <input class="form-control" type="file" name="image">
            @error('image')
            {{$message}}
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Titre</label>
            <input class="form-control" type="text" name="title" value='{{old('title', $post->title)}}'>
            @error('title')
            {{$message}}
            @enderror
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input class="form-control" type="text" name="slug" value="{{old('slug', $post->slug)}}">
            @error('slug')
            {{$message}}
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea class="form-control" name="content" >{{old('content', $post->content)}}</textarea>
            @error('content')
            {{$message}}
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Catégorie</label>
            <select class="form-control" id="category" name="category_id" >
                <option>Sélectionner une catégorie</option>
                @foreach($categories as $category)
                    <option @selected(old('category_id', $post->category_id) == $category->id) value="{{$category->id}}" >{{$category->name}}</option>
                @endforeach
            </select>
            @error('category_id')
            {{$message}}
            @enderror
        </div>
        @php
        //Sur les collection on a une methode pluck qui permet de récupérer toutes les infos et de renvoyer que les valeurs qui correspondent au champ
        //$tagIds=($post->tags->pluck('id')) aurait marché mais matières performance, la 2eme relation est la mieux adaptée. Car la requête sql est plus simple que la prémière
            $tagIds=($post->tags()->pluck('id')) //cette ligne de code extrait les IDs des tags associés à un article spécifique afin de les vérifier et les sélectionner par défaut
        //Au niveau du name, on a name='tag[]' cela parce qu'on s'attend à avoir un tableau de tags
        @endphp
        <div class="form-group">
            <label for="tag">Tags</label>
            <select class="form-control" id="tag" name="tags[]" multiple >
                <option>Sélectionner un tag</option>
                @foreach($tags as $tag)
                    <option @selected($tagIds->contains($tag->id)) value="{{$tag->id}}" >{{$tag->name}}</option>
                @endforeach
            </select>
            @error('$tags')
            {{$message}}
            @enderror
        </div>
        <!-- On parvient à cette vérification grace à la création de l'objet post vide dans blog.controller-->
        <button class="btn btn-primary">
            @if($post->id)
              Modifier
            @else
                Créer
            @endif
        </button>
    </form>


@endsection

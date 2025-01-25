<!-- Cela étend de notre fichier base.blade.php -->
@extends('base')

<!-- Changeons la valeur du titre dynamiquement -->
@section('title', 'Ma page d\'accueil')

<!-- Pour lui dire de prendre le contenu de cette page et de le mettre dans la section content -->
@section('content')
<h1>Mon blog</h1>

@foreach ($posts as $post)
<!-- On remarque que lors de l'envoie de posts dans la vue du controller il permet de créer un variable $posts
que l'on peut automatiquement récupérer ici
-->

    <article>
        <h2>{{$post->title}}</h2>
        <p class="small">
            @if($post->category)
                Catégorie: <strong>{{$post->category?->name}}</strong>@if(!$post->tags->isEmpty()), @endif
            @endif
            @if(!$post->tags->isEmpty())
                Tag:
                @foreach($post->tags as $tag)
                    <span class="badge bg-secondary">{{$tag->name}}</span>
                @endforeach
            @endif
        </p>

        @if($post->image)
            <!-- On aurait pu utiliser cela à la place mais on a préféré la méthode dynamique src="/storage/{\{$post->image}}" -->
            <img style="width: 500px; height: 300px; object-fit: cover;" src="{{$post->imageUrl()}} " alt="">
        @endif

        <p>{{$post->content}}</p>
        <p><a href="{{ route('blog.show', ['slug' => $post->slug,'post'=> $post->id]) }}" class="btn btn-primary" >lire la suite</a></p>
    </article>
@endforeach
<!-- Permet de créer des liens pour la pagination -->
{{$posts->links()}}
@php
 //@dump($posts) permet de dumper sous forme de code

@endphp


@endsection

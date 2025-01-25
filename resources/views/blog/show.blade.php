<!-- Cela étend de notre fichier base.blade.php -->
@extends('base')

<!-- Changeons la valeur du titre dynamiquement -->
@section('title', $post->title)

<!-- Pour lui dire de prendre le contenu de cette page et de le mettre dans la section content -->
@section('content')
    <article>
        <h2>{{$post->title}}</h2>
        <p>{{$post->content}}</p>
    </article>
@endsection

{{-- resources/views/articles/edit.blade.php --}}

@extends('layouts.app')

@section('content')
    <h1>Editare Articol</h1>
    <form method="post" action="{{ route('articles.update', $article->id) }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="title">Titlu</label>
            <input type="text" name="title" id="title" value="{{ $article->title }}">
        </div>

        <div>
            <label for="content">Conținut</label>
            <textarea name="content" id="content">{{ $article->content }}</textarea>
        </div>

        <button type="submit">Actualizează Articolul</button>
    </form>
@endsection

{{-- resources/views/articles/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Article List')

@section('content')
    <h1>Articles</h1>
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article->title }} - {{ $article->content }}</li>
        @endforeach
    </ul>
@endsection

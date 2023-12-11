{{-- resources/views/journalist/articles.blade.php --}}

@extends('layouts.app')

@section('content')
    <h1>Articolele Jurnalistului</h1>
    @forelse ($articles as $article)
        <article>
            <h2>{{ $article->title }}</h2>
            <div>{{ $article->content }}</div>
            <span>Publicat la: {{ $article->created_at->format('d M Y') }}</span>
        </article>
    @empty
        <p>Nu există articole de afișat.</p>
    @endforelse
@endsection

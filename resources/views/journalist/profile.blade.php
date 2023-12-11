{{-- resources/views/journalist/profile.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profilul Jurnalistului</h1>
        <div class="card">
            <div class="card-body">
                <h2>{{ $journalist->name }}</h2>
                <p>{{ $journalist->biography }}</p>
            </div>
        </div>
        <h3>Articole</h3>
        @if($articles->isNotEmpty())
            <ul class="list-group">
                @foreach($articles as $article)
                    <li class="list-group-item">
                        <h4>{{ $article->title }}</h4>
                        <p>{{ \Illuminate\Support\Str::limit($article->content, 200) }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-primary">Citeste mai mult</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nu există articole încărcate de acest jurnalist.</p>
        @endif
    </div>
@endsection

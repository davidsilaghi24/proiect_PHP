@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <div class="mb-4">
                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    Bun venit, {{ Auth::user()->name }}!
                </div>
                <div class="mt-2 text-md text-gray-600">
                    Rol: <span class="text-blue-500 font-semibold">{{ Auth::user()->getRoleNames()->join(', ') }}</span>
                </div>
            </div>

            @if(Auth::user()->hasRole('jurnalist'))
                <div style="background-color: black;">
                    <a href="{{ route('articles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                        Crează Articol Nou
                    </a>
                </div>
            @endif

              <!-- Listarea articolelor -->
              <div class="w-full md:w-1/2">
                    <div class="space-y-3">
                        @forelse ($articles as $article)
                            <div class="p-2 hover:bg-blue-100 rounded">
                                <a href="{{ route('articles.edit', $article) }}" class="text-blue-700 hover:underline">
                                    {{ $article->title }} {{-- Titlul articolului --}}
                                </a>
                            </div>
                        @empty
                            <p>Nu există articole de afișat.</p> {{-- Mesaj dacă nu există articole --}}
                        @endforelse
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

{{-- Layout-ul principal al aplicației --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Card pentru articol --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Titlul articolului --}}
                    <h3 class="text-lg font-bold mb-3">
                        {{ $article->title }}
                    </h3>
                    {{-- Data publicării --}}
                    <p class="text-sm text-gray-600">
                        Published on {{ $article->created_at->format('F d, Y') }}
                    </p>
                    {{-- Conținutul articolului --}}
                    <div class="mt-6 text-gray-700">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                    {{-- Buton de întoarcere --}}
                    <div class="mt-6">
                        <a href="{{ route('articles.index') }}" class="text-indigo-600 hover:text-indigo-900 transition ease-in-out duration-150">
                            ← Back to all articles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

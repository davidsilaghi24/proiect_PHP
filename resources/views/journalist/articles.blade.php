<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articolele Mele') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-4">Adaugă Articol Nou</a>
                    <!-- Articles list -->
                    <ul>
                        @forelse ($articles as $article)
                            <li>
                                <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                                <span class="text-sm text-gray-600">Publicat la: {{ $article->published_at->format('d/m/Y') }}</span>
                                <!-- Edit and delete buttons -->
                                <a href="{{ route('articles.edit', $article->id) }}" class="text-indigo-600 hover:text-indigo-900">Editare</a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Sigur doriți să ștergeți articolul?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Ștergere</button>
                                </form>
                            </li>
                        @empty
                            <li>Nu există articole de afișat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

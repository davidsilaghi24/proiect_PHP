<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul>
                        @forelse ($articles as $article)
                            <li class="mb-4 p-4 border-b last:border-b-0">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <a href="{{ route('articles.show', $article) }}" class="text-lg font-semibold">{{ $article->title }}</a>
                                        <p class="text-sm text-gray-600">{{ Str::limit($article->content, 100) }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ route('articles.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                        {{-- Formularul de ștergere poate fi adăugat aici --}}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>{{ __('No articles found.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

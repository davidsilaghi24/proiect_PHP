<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profilul Jurnalistului') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Profil Information -->
                    <div class="mb-6">
                        <!-- Display the journalist's name and email -->
                        <p><strong>Nume:</strong> {{ $journalist->name }}</p>
                        <p><strong>Email:</strong> {{ $journalist->email }}</p>
                    </div>

                    <!-- Add a section for the biography -->
                    <div class="mb-6">
                        <strong>Biografie:</strong>
                        <p>{{ $journalist->biography }}</p>
                    </div>

                    <!-- Add a section for the journalist's articles -->
                    <div>
                        <strong>Articole Publicate:</strong>
                        <ul>
                            @forelse ($journalist->articles as $article)
                                <li>{{ $article->title }} - Publicat la: {{ $article->published_at->format('d/m/Y') }}</li>
                            @empty
                                <li>Niciun articol publicat.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Edit profile button -->
                    <a href="{{ route('journalist.edit', $journalist->id) }}" class="text-indigo-600 hover:text-indigo-900">Editare Profil</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

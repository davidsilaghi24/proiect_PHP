<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('articles.update', $article) }}" method="POST" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @csrf
                @method('PUT')
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $article->title) }}" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-textarea id="content" class="block mt-1 w-full" name="content" rows="10" required>{{ old('content', $article->content) }}</x-textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

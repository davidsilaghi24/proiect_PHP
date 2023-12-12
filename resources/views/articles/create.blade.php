{{-- articlecreate.blade.php --}}
@extends('layouts.app') {{-- Extinde layout-ul principal al aplicației --}}

@section('header') {{-- Începutul secțiunii header --}}
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create New Article') }} {{-- Titlul paginii de creare a articolului --}}
    </h2>
@endsection {{-- Sfârșitul secțiunii header --}}

@section('content') {{-- Începutul secțiunii content --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Începutul formularului --}}
        <form action="{{ route('articles.store') }}" method="POST" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @csrf {{-- Token CSRF pentru securitate --}}
            <div class="p-6 bg-white border-b border-gray-200">
                {{-- Titlul articolului --}}
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                    <input id="title" name="title" type="text" class="block mt-1 w-full form-input" value="{{ old('title') }}" required autofocus />
                    @error('title')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Conținutul articolului --}}
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                    <textarea id="content" name="content" rows="5" class="block mt-1 w-full form-textarea" required>{{ old('content') }}</textarea>
                    @error('content')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buton de submit --}}
                <div class="flex items-center justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded" style="color: black; background-color: green;">
                    {{ __('Publish Article') }}
                </button>
                </div>
            </div>
        </form>
        {{-- Sfârșitul formularului --}}
    </div>
</div>
@endsection {{-- Sfârșitul secțiunii content --}}

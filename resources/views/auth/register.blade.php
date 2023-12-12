<x-guest-layout>
    <div class="w-full max-w-xs mx-auto pt-8">

        <!-- Titlul Paginii -->
        <h2 class="text-center text-2xl font-bold mb-6">Înregistrează-te pe Portalul de Jurnalism</h2>

        <!-- Formularul de Înregistrare -->
        <form method="POST" action="{{ route('register') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <!-- Nume -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Nume')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Adresa de Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Parola -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Parola')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmarea Parolei -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirmă Parola')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Roluri Dropdown -->
            <div class="mb-6">
                <x-input-label for="role" :value="__('Alege Rolul')" />
                <select id="role" name="role" class="block mt-1 w-full" required>
                    <option value="" disabled selected>Selectează rolul</option>
                    <option value="jurnalist">Jurnalist</option>
                    <option value="editor">Editor</option>
                    <option value="cititor">Cititor</option>
                    <option value="administrator">Administrator</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Buton de Înregistrare -->
            <div class="flex items-center justify-between">
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('login') }}">
                    {{ __('Ai deja cont? Autentifică-te') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Înregistrează-te') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Informații suplimentare -->
        <p class="text-center text-gray-500 text-xs">
            &copy;{{ now()->year }} Portalul de Jurnalism. Toate drepturile rezervate.
        </p>
    </div>
</x-guest-layout>

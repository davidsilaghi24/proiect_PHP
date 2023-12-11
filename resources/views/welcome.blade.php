<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Platforma Jurnaliștilor - Acasă</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
            @if (Route::has('login'))
                <div class="absolute top-0 right-0 p-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-white">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-gray-700 dark:text-white">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Bine ați venit pe Platforma Jurnaliștilor</h1>
                    <p class="mt-3 text-lg text-gray-700 dark:text-gray-300">Explorați ultimele articole și descoperiți perspectiva jurnaliștilor pe diferite teme.</p>
                </div>

                <!-- Featured Articles Section -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Placeholder for articles; dynamic content should be loaded here -->
                </div>
            </div>

            <div class="text-center py-6 text-sm text-gray-600 dark:text-gray-400">
                © {{ date('Y') }} Platforma Jurnaliștilor - Toate drepturile rezervate
            </div>
        </div>
    </body>
</html>

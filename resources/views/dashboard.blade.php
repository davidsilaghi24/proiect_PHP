<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panou de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Bine ai venit în Panoul de Control al Portalului de Jurnalism!") }}
                    <p class="mt-4">
                        Aici poți să îți gestionezi articolele, să vezi statistici și să primești noutăți despre activitatea ta recentă.
                    </p>
                </div>
            </div>
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg leading-tight">
                        {{ __('Articolele Tale Recente') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

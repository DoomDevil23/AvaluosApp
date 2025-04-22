<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <h2>Siga caminando joven!</h2>
                        
                        <img src="https://i.pinimg.com/736x/01/19/1f/01191fd3ece2dcd44122ff6d88149abc.jpg" alt="Dashboard Image" class="w-full max-w-md rounded-lg shadow-md">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

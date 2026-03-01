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
                    <h3 class="text-lg font-medium mb-4">¡Bienvenido, {{ Auth::user()->nombre }}!</h3>
                    <p>Has iniciado sesión correctamente en Doctor Domicilio.</p>
                    
                    @if(Auth::user()->isAdmin())
                        <div class="mt-4 p-4 bg-blue-100 dark:bg-blue-900 rounded">
                            <p class="text-blue-800 dark:text-blue-200">Tienes permisos de administrador.</p>
                        </div>
                    @endif
                    
                    @if(Auth::user()->isDoctor())
                        <div class="mt-4 p-4 bg-green-100 dark:bg-green-900 rounded">
                            <p class="text-green-800 dark:text-green-200">Tienes permisos de doctor.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-center my-10" >{{ __('My notifications') }}</h1>

                    @forelse ( $notificaciones as  $notificacion)
                        {{-- creo que el flex lo que hace es mover las cosas para un lado y otro, en cambio en grid divide la pantalla en x cantidad de partes --}}
                        {{-- items-center es para centrarlo verticalmente --}}
                        <div class="p-5 border border-gray-200 lg:flex lg:justify-between lg:items-center">
                            <div>
                                <p>
                                    Tienes un nuevo candidato en la vacante:
                                    <span class="font-bold">{{ $notificacion->data['titulo_vacante'] }}</span>
                                </p>

                                <p>
                                    <span class="font-bold">{{ $notificacion->created_at->diffForHumans() }}</span>
                                </p>
                            </div>

                            <div class="mt-5 lg:mt-0">
                                <a class="dark:bg-indigo-500 p-3 text-sm uppercase font-bold text-white rounded-lg" >Ver candidato</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-600" >No hay notificaciones nuevas</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

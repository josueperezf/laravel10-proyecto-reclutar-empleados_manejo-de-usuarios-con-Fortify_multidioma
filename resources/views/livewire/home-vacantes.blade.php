<div>
    {{-- renderizamos el componente para el buscador --}}
    <livewire:filtrar-vacantes/>
    <div class="py-12">
        {{-- mx-auto para que este centrado --}}
        <div class="max-w-7xl mx-auto">
            {{-- recordemos que __('') es para que traduzca el texto que esta alli, lo va a buscar en el archivo es.json  --}}
            <h3 class="font-extrabold text-4xl text-gray-700 dark:text-gray-300 mb-12" > {{ __('Vacancies available') }}</h3>

            {{-- divide es para que si este div tiene hijos, que cada uno de ellos tenga una linea divisoria,  --}}
            {{-- divide-gray-200 es para darle color a esa linea  divisoria --}}
            <div class="bg-white shadow-sm rounded-lg p-6 divide-y divide-gray-200">
                @forelse ($vacantes as $vacante)
                    {{-- justify-between es para hacer que cada div hijo que tenga el siguiente div, sera como una columna de una tabla por asi decirlo, claro debe colocar que es flex --}}
                    <div class="md:flex md:justify-between  md:items-center py-5">
                        {{-- flex-1 es para que el siguiente div sea ancho todo el espacio que no este ocupando el siguente div 2, recordemos que con flex los div son anchos lo que ocupe su contenido, si tiene solo hola, pues su ancho sera lo que ocupen esta 4 letras --}}
                        <div class="md:flex-1 ">
                            <a
                                class="text-3xl font-extrabold text-gray-600"
                                href="{{ route('vacantes.show', ['vacante'=>$vacante]) }}"
                            >
                                {{ $vacante->titulo }}
                            </a>
                            <p class="text-base text-gray-600 mb-1">
                                {{ $vacante->empresa }}
                            </p>
                            <p class="font-bold text-xs text-gray-600">
                                {{ __('Last day to apply') }}
                                <span>{{ $vacante->ultimo_dia->format('d/m/Y') }}</span>
                            </p>
                        </div>

                        <div class="mt-5 md:mt-0">
                            <a
                                href="{{ route('vacantes.show', ['vacante'=>$vacante]) }}"
                                class="dark:bg-indigo-500 p-3 text-sm uppercase font-bold text-white rounded-lg block text-center"
                            >
                                {{ __('See vacancy') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="p-3 text-center text-sm text-gray-600 " >
                        {{ __('There are no vacancies yet') }}
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    {{-- este @forelse es una combinación entre foreach y un else si no hay informacion para mostrar--}}
    @forelse ($vacantes as $vacante)
        <div class="p-6 bg-white border-b border-gray-200 md:flex md:justify-between md:items-center">
            {{-- leading-10 es para aumentar el interlineado --}}
            <div class="space-y-3">
                <a class="text-xl font-bold ">
                    {{ $vacante->titulo }}
                </a>
                <p class="text-sm text-gray-600 font-bold" >{{ $vacante->empresa }}</p>
                {{-- para poder manejar la fecha de esta manera en laravel, debo en el modelo de vacante, colocar lo siguiente protected $casts = [ 'ultimo_dia'=>'date']; --}}
                <p class="text-sm text-gray-500" >{{ __('Last day') }}: {{ $vacante->ultimo_dia->format('d/m/Y') }}</p>
            </div>

            {{--
                flex-row para que los 3 botones se vean uno al lado del otro,
                pero cuando pase a pantallas medianas o menores, entonces se utilizara flex-row para que pongan los iconos uno bajo el otro.
                con items-stretch hacemos que el boton se estire al ancho del espacio
            --}}
            <div class="flex flex-col md:flex-row items-stretch gap-3 mt-5 md:mt-0 ">
                <a class="bg-slate-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center " >
                    Candidatos
                </a>
                <a class="bg-blue-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center " >
                    Editar
                </a>
                <a class="bg-red-600 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center " >
                    Eliminar
                </a>
            </div>
        </div>
    @empty
        <p class="p-3 text-center text-sm text-gray-600" >No hay vacantes</p>
    @endforelse
</div>

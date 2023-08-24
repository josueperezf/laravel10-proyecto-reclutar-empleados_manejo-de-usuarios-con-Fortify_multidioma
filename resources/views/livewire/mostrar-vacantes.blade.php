<div>
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
                    <a href="{{ route('vacantes.edit', ['vacante'=>$vacante]) }}" class="bg-blue-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center " >
                        Editar
                    </a>
                    <button
                        class="bg-red-600 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase text-center "
                        {{-- la siguiente linea comentada emite un evento, que llama a un metodo php en el archivo MostrarVacante.php, el $emit es obligatorio colocarlo --}}
                        {{-- wire:click="$emit('prueba', {{ $vacante->id }})" --}}

                        {{-- la siguiente linea es similar a la anterior comentada, pero esta llama a un metodo javascript, para que funcione en javascript debe tener la paralabra Livewire.on('nombreFuncion', (parametros)=>{}) --}}
                        wire:click="$emit('confirmarElimacionDeVacante', {{ $vacante->id }})"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
        @empty
            <p class="p-3 text-center text-sm text-gray-600" >No hay vacantes</p>
        @endforelse
    </div>


    {{-- para mostrar la paginacion --}}
    <div class="mt-10">
        {{ $vacantes->links() }}
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Livewire.on('confirmarElimacionDeVacante', (id) => {
        //     alert(id)
        // });

        Livewire.on('confirmarElimacionDeVacante', (id) => {
            // muestro el alert para que acepte o no eliminar la vacante
            Swal.fire({
                title: 'Eliminar Vacante?',
                text: "Una vacante eliminada no se puede recuperar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar',
              }).then((result) => {
                if (result.isConfirmed) {
                    // llamamos al metodo 'eliminarVacante' de la clase php MostrarVacantes, con el id
                    Livewire.emit('eliminarVacante', id)
                  Swal.fire(
                    'Se elimino la vacante!',
                    'Eliminado correctamente.',
                    'success'
                  )
                }
              })
        });

    </script>
@endpush


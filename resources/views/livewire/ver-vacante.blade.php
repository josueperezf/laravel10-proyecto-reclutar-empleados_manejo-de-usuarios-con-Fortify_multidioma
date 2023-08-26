<div class="p-10">
    <div class="mb-5">
        <h3 class="font-bold text-3xl text-gray-800 my-3">{{ $vacante->titulo }}</h3>

        {{-- creo dos columnas para solo pantallas medianas y grandes, para movil ya seria solo una columna, excelente --}}
        <div class="md:grid md:grid-cols-2 ">
            <p class="font-bold text-sm uppercase text-gray-800 my-3" >{{ __('Company') }}:
                <span class="normal-case font-normal" >{{ $vacante->empresa }}</span>
            </p>

            <p class="font-bold text-sm uppercase text-gray-800 my-3" >{{ __('Last day to apply') }}:
                <span class="normal-case font-normal" >
                    {{ $vacante->ultimo_dia->format('d-m-Y') }}
                </span>
            </p>

            <p class="font-bold text-sm uppercase text-gray-800 my-3" >{{ __('Category') }}:
                <span class="normal-case font-normal" >
                    {{--  es dos veces categoria porque el profesor en el modelo categoria en vez de llamarlo nombre o titulo o lo que sea, lo llamo categoria--}}
                    {{ $vacante->categoria->categoria }}
                </span>
            </p>

            <p class="font-bold text-sm uppercase text-gray-800 my-3" >{{ __('Monthly salary') }}:
                <span class="normal-case font-normal" >
                    {{ $vacante->salario->salario }}
                </span>
            </p>
        </div>
    </div>


    {{-- va a dividir la pantalla en 6 partes, el primer div tendra 2 partes y el otro div tendra 4 --}}
    <div class="md:grid md:grid-cols-6 md:gap-4">
        <div class="md:col-span-2">
            <img src="{{ asset('storage/vacantes'.$vacante->imagen) }}" alt="imagen vacante" />
        </div>

        <div class="md:col-span-4">
            <h2 class="text-2xl font-bold mb-5" >{{ __('Job Overview') }} </h2>
            <p>{{ $vacante->descripcion }}</p>
        </div>
    </div>

    {{-- para que se postulen las personas no logueadas, mejor dicho para que se registren --}}
    @guest
        <div class="mt-5 bg-gray-50 border border-dashed p-5 text-center">
            <p>
                {{ __('Do you want to apply?') }}
                <a class="font-bold text-indigo-600" href="{{ route('register') }}" >
                    {{ __('Get an account apply to this and other vacancies') }}
                </a>
            </p>
        </div>
    @endguest

    {{--
        los '@can' son como un 'if' con su else y demas de programacion. @cannot es como si negaramos el 'if'
        con la diferencia que lo que va en parentesis:
        1. primero: es el nombre del método al que vamos a invocar.
        2. segundo: es la clase policy donde esta ese metodo, para este ejemplo es VacantePolicy
        tod0 esto es mas o menos similar a lo que colocamos en el controlador de VacanteController.php donde decimos ejemplo
        $this->authorize('create', Vacante::class).
        en las vistas las clases se deben colocar con la ruta completa, como se ve acontinuacion
    --}}
    {{-- @can('create', App\models\Vacante::class)
        <p>Este es un reclutador</p>
    @else
        <p>Este es un Programador</p>
        <livewire:postular-vacante/>
    @endcan --}}

    {{-- como necesitamos mostrar el usuario solo para los programadores entonces utilizamos el  --}}

    {{--
        pense en colocar directamente un IF,
        pero buscandole la logica, noto que si cambio la regla de quienes pueden crear,
        al tenerla centralizado en el policy entonces no tendria que ir lugar a lugar actualizando el if.
        solo en este caso pregunto que usuario no tiene permido de crear un modelo, eso es lo que quiere decir la siguiente linea
    --}}


    @cannot('create', App\models\Vacante::class)
        {{-- los dos puntos es porque el contenido viene de una variable php :vacante="vacante" --}}
        @auth
            <livewire:postular-vacante :vacante="$vacante" />
        @endauth
    @endcannot

</div>

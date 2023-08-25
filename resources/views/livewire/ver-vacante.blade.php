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
</div>

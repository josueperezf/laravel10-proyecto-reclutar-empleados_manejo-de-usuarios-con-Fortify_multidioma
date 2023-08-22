{{--
    !!!SUPER IMPORTANTE!!!!

    1. este formulario esta asociado directo a la clase CrearVacante,
    los inputs por lo general tiene el campo name, bueno, para que se contecte con livewire en el real time,
    el input no de debe tener la propiedad name='titulo', si no en su lugar una llamada wire:model='titulo'.
    ademas de lo anterior, la clase 'CrearVacante', debe tener una variable o propiedad con el nombre del input al que va a controlar
    esto hace que cada vez que se coloque un caracter en la caja de texto, se hara una peticcion http,
    la misma llegara a la clase 'CrearVacante' donde se tendran las validaciones y demas

    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required|numeric|min:1',
        'categoria' => 'required|numeric|min:1',
        'empresa' => 'required|string',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen' => 'required',

    ];

    2. ahora hay que decirle al wirelive que procese este formulario,
    para ello, en la etiqueta form debemos agregarle la propiedad "wire:submit.prevent='guardarVacante'"
    'guardarVacante' es el nombre del metodo de la clase 'CrearVacante' que procesara nuestro formulario al hacer submit

    3. lo que tenga ':' significa que el valor va a venir de una variable dinamica,
    ejemplo :placeholder="__('Vacant title')" . el placeholder va a ser dinamico ya que su valor va a ser el resultado de traducir el string 'Vacant title'.
    <x-input-error :messages="abc" /> => al componente 'input-error' le estamos pasando una variable llamada 'messages', y su valor es abc

    4.  para poder enviar imagenes con livewire se debe colocar en la clase CrearVacante lo siguiente 'use WithFileUploads;'

--}}
<form class="md:w-1/2 space-y-5" wire:submit.prevent='guardarVacante'>
    {{--   space-y-5 separa los div hijos del form por 5, solo los div hijos no los nietos --}}
    @csrf
    <!-- Titulo -->
    <div >
        <x-input-label for="titulo" :value="__('Title')" />
        <x-text-input
            id="titulo" class="block mt-1 w-full" type="text"
            wire:model='titulo'
            :value="old('titulo')"
            :placeholder="__('Vacant title')" />
        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
        {{-- FORMA VIEJA DE MOSTRAR EL ERROR, con el componente x-input-error evitamos hacer todo lo comentado
            @error('titulo')
                <p>$message</p>
            @enderror
         --}}
    </div>

    <!-- Salario -->
    <div class="mt-2">
        <x-input-label for="salario" :value="__('Salary')" />
        <x-select-input id="salario" wire:model='salario' :value="old('salario')" >
            <option value="">SELECCIONE SALARIO</option>
            @foreach ($salarios as $salario)
                <option value="{{ $salario->id }}">{{ $salario->salario }}</option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('salario')" class="mt-2" />
    </div>

    <!-- Categoria -->
    <div class="mt-2">
        <x-input-label for="categoria" :value="__('Category')" />
        <x-select-input id="categoria" wire:model='categoria' :value="old('categoria')" >
            <option value="">SELECCIONE CATEGORIA</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('categoria')" class="mt-2" />
    </div>

    <!-- Empresa -->
    <div class="mt-2">
        <x-input-label for="empresa" :value="__('Company')" />
        <x-text-input id="empresa" class="block mt-1 w-full" type="text" wire:model='empresa' :value="old('empresa')" :placeholder="__('Company').' Ej: Netflix, Uber, Shopify'" />
        <x-input-error :messages="$errors->get('empresa')" class="mt-2" />
    </div>

    <!-- Ultimo dia para postularse -->
    <div class="mt-2">
        <x-input-label for="ultimo_dia" :value="__('Last day to apply')" />
        <x-text-input id="ultimo_dia" class="block mt-1 w-full" type="date" wire:model='ultimo_dia' :value="old('ultimo_dia')" />
        <x-input-error :messages="$errors->get('ultimo_dia')" class="mt-2" />
    </div>

    <!-- Descripcion -->
    <div class="mt-2">
        <x-input-label for="descripcion" :value="__('Job Overview')" />
        <textarea wire:model="descripcion" :value="old('descripcion')" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full h-72 " ></textarea>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>


    <!-- Imagen -->
    <div class="mt-2">
        <x-input-label for="imagen" :value="__('Image')" />
        <x-text-input id="imagen" class="block mt-1 w-full" type="file" wire:model="imagen" accept="image/*" />
        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
        <div class="my-5 w-80">
            {{-- two way data binding --}}
            {{-- la variable $imagen esta disponible porque tenemos un input con wire:model="imagen" --}}
            @if ($imagen && !$errors->has('imagen'))
                Imagen: <img src="{{ $imagen->temporaryUrl() }}"  />
            @endif
        </div>
    </div>

    {{--
        IMPORNTANTE:

        livewire cada vez que se escribe en cualquier input llama al backend para guardar ese contenido en la variable que tiene el mismo nombre del input,
        por ende, livewire invoca un loading que ellos tienen,
        este no lo puedo utilizar para deshabilitar el boton submit, o colocar la imagen cargando,
        ya que se veria raro que con cada letra que escriban en el formulario salga la imagen de cargando,
        para solucionar en la clase CrearVacante se creó la propiedad 'cargando',
        y decimos que al presionar el boton submit, ademas de hacer el submit,
        primero llame a la funcion que cree  llamada 'cargador', esta lo que hace es cambiar el valor iniciar de la variable 'cargando',
        y decimos que se muestre el svg de cargando solo si hay un 'loading' y si se llamo a la funcion 'cargador'
    --}}
    <div class="mt-4">
        <x-primary-button
            wire:click="cargador"
            wire:loading.attr="disabled"
            wire:target="cargador"
        >
            {{ __('Create vacancy') }} &nbsp;
            <div wire:loading wire:target="cargador"  class="animate-spin h-4 w-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>

        </x-primary-button>
    </div>
</form>

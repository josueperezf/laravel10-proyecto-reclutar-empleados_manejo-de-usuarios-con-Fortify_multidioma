<form class="md:w-1/2 space-y-5">
    {{--   space-y-5 separa los div hijos del form por 5, solo los div hijos no los nietos --}}
    @csrf
    <!-- Titulo -->
    <div >
        <x-input-label for="titulo" :value="__('Title')" />
        <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" :placeholder="__('Vacant title')" />
        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    </div>

    <!-- Salario -->
    <div class="mt-2">
        <x-input-label for="salario" :value="__('Salary')" />
        <x-select-input id="salario" name='salario' :value="old('salario')" >
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
        <x-select-input id="categoria" name='categoria' :value="old('categoria')" >
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
        <x-text-input id="empresa" class="block mt-1 w-full" type="text" name="empresa" :value="old('empresa')" :placeholder="__('Company').' Ej: Netflix, Uber, Shopify'" />
        <x-input-error :messages="$errors->get('empresa')" class="mt-2" />
    </div>

    <!-- Ultimo dia para postularse -->
    <div class="mt-2">
        <x-input-label for="ultimo_dia" :value="__('Last day to apply')" />
        <x-text-input id="ultimo_dia" class="block mt-1 w-full" type="date" name="ultimo_dia" :value="old('ultimo_dia')" />
        <x-input-error :messages="$errors->get('ultimo_dia')" class="mt-2" />
    </div>

    <!-- Descripcion -->
    <div class="mt-2">
        <x-input-label for="descripcion" :value="__('Job Overview')" />
        <textarea name="descripcion" :value="old('descripcion')" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full h-72 " ></textarea>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>

    <!-- Titulo -->
    <div class="mt-2">
        <x-input-label for="imagen" :value="__('Image')" />
        <x-text-input id="imagen" class="block mt-1 w-full" type="file" name="imagen" />
        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-primary-button >
            {{ __('Create vacancy') }}
        </x-primary-button>
    </div>
</form>

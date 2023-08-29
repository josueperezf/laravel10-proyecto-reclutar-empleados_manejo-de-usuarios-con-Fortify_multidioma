<div class="bg-gray-100 py-10">
    <h2 class="text-2xl md:text-4xl text-gray-600 text-center font-extrabold my-5">Buscar y Filtrar Vacantes</h2>
    <p  class="max-w-7xl mx-auto mb-4"> El termino se busca en db en titulo de la vacante o empresa que postulo la oferta laboral</p>
    <div class="max-w-7xl mx-auto">
        <form wire:submit.prevent='leerDatosFormulario' >
            <div class="md:grid md:grid-cols-3 gap-5">
                <div class="mb-5">
                    <label
                        class="block mb-1 text-sm text-gray-700 uppercase font-bold "
                        for="termino">Término de Búsqueda.
                    </label>
                    <input
                        id="termino"
                        {{-- recordemos que wire:model es para asociar este input a una propiedad de la clase FiltrarVacante.php, especificamente con la variable de esa clase llamada 'termino' --}}
                        wire:model="termino"
                        type="text"
                        placeholder="Buscar por Término: ej. Laravel"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
                    />
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Categoría</label>
                    {{-- recordemos que wire:model es para asociar este input a una propiedad de la clase FiltrarVacante.php, especificamente con la variable de esa clase llamada 'categoria' --}}
                    <select class="border-gray-300 p-2 w-full" wire:model="categoria_id">
                        <option value="">--Seleccione--</option>

                        @foreach ($categorias as $categoria )
                            <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Salario Mensual</label>
                    {{-- recordemos que wire:model es para asociar este input a una propiedad de la clase FiltrarVacante.php, especificamente con la variable de esa clase llamada 'salario' --}}
                    <select class="border-gray-300 p-2 w-full" wire:model="salario_id" >
                        <option value="">-- Seleccione --</option>
                        @foreach ($salarios as $salario)
                            <option value="{{ $salario->id }}">{{$salario->salario}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <input
                    type="submit"
                    class="bg-indigo-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-10 py-2 rounded cursor-pointer uppercase w-full md:w-auto"
                    value="Buscar"
                />
            </div>
        </form>
    </div>
</div>

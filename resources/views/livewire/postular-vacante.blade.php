<div class=" bg-gray-500 mt-10 flex flex-col justify-center items-center rounded shadow-md " >
    <h3 class="text-center text-2xl font-bold my-4 dark:text-white ">{{ __('Apply for this vacancy') }}</h3>

    {{-- para los mensajes que envia el backend, la variable se llama mensaje y se envio mediante session --}}
    @if (session()->has('mensaje'))
        <p class=" uppercase border border-green-600 bg-green-100 text-green-600 font-bold p-2 my-5 text-sm">
            {{ session('mensaje') }}
        </p>
    @endif

    <form class="w-96 mt-5" wire:submit.prevent='postularme' >
        <div class="mb-4">
            <x-input-label for="cv" :value="__('Curriculo')" />
            <x-text-input
                id="cv" class="block mt-1 w-full dark:bg-white dark:text-gray-500 border-none"
                type="file" accept=".pdf"
                wire:model='cv'
                {{-- :value="old('cv')" --}}
            />
            <x-input-error :messages="$errors->get('cv')" class="mt-2" />
        </div>

        <div class="my-5">
            <x-primary-button wire:loading.attr="disabled">
                {{ __('Apply') }} &nbsp;
                <div wire:loading class="animate-spin h-4 w-4" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>

            </x-primary-button>
        </div>

    </form>
</div>

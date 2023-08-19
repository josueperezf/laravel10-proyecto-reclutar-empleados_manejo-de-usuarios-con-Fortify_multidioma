{{--
    la siguiente linea es para que cualquier otro parametro que pasen a este componente,
    como por ejemplo class='mi-clase-css', id='abc' etc, esto se agregue a este componente,
    o mejor dicho al <ul></ul> que aqui estamos creando
--}}
@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

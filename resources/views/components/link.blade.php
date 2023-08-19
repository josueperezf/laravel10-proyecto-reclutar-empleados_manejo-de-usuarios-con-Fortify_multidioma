{{--
    IMPORTANTE:

    Los componentes en laravel, por lo general reciben dos propiedades,
    1. es el $slot que es todo lo que colocamos entre la apertura y cierre de la etiqueta cuando lo llamamos, algo como los child en react
    2. otro son los $attributes, esto no se lo pasamos pero laravel internamente se lo pasa, en nosotros esta si lo utilizamos,
    ello nos ayuda a recibir propiedades que le pase a nuestro componentes y vaciarlas aqui, algo como id='xxx' o href='' o mas clases css si asi lo deseamos, no reemplaza a las qie tenemos en este array, si no las adiciona al final

    El archivo Link.php se borro ya que no se necesitaba, estos archivos no son obligatorios, sirven solo si queremos hacer algun procesamiento o algo asi

--}}

@php
    $clases = " text-xs text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800";
@endphp

<a {{ $attributes->merge(['class' => $clases]) }}>
    {{ $slot }}
</a>

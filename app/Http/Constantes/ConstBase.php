<?php

namespace App\Http\Constantes;

use ReflectionClass;

class ConstBase
{
    /**
     * Obtiene un arreglo asociativo con las constantes de la clase.
     * Tener en cuenta que la clase hija hereda todas las constantes de
     * la clase padre, por eso también se obtendrán las constantes de la
     * clase padre.
     * @return array
     */
    public static function obtenerConstantes(): array {
        $clase = get_called_class();
        $instancia = new $clase;
        return (new ReflectionClass($instancia))->getConstants();
    }

    public static function invertirKeyValue() : array {
        $clase = get_called_class();
        $instancia = new $clase;
        $elements = (new ReflectionClass($instancia))->getConstants();
        $resp = [];
        foreach ($elements as $key => $value) {
            $resp[$value] = $key;
        }
        return $resp;
    }
}

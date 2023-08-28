<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use Livewire\Component;

class FiltrarVacantes extends Component {
    public $termino;
    public $categoria;
    public $salario;

    public function render() {
        $salarios = Salario::all();
        $categorias = Categoria::all();
        return view('livewire.filtrar-vacantes', compact('salarios','categorias'));
    }

    // este metodo se llama cuando se dispare el submit de la vista filtrar-vacantes.php
    public function leerDatosFormulario() {
        dd('buscando...');
    }
}

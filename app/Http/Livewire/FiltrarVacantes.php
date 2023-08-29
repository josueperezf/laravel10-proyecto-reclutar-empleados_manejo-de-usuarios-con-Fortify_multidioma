<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use Livewire\Component;

class FiltrarVacantes extends Component {
    public $termino;
    public $categoria_id;
    public $salario_id;

    public function render() {
        $salarios = Salario::all();
        $categorias = Categoria::all();
        return view('livewire.filtrar-vacantes', compact('salarios','categorias'));
    }

    // este metodo se llama cuando se dispare el submit de la vista filtrar-vacantes.php
    public function leerDatosFormulario() {
        /* este ->emit() LO QUE HACE ES EMITIR UN EVENTO QUE VA A SER ESCUCHADO POR ALGUIEN PARA ESTE EJEMPLO,
        EN LA CLASE HomeVacantes hay una variable  protected $listeners = ['eventoFiltrar'=>'buscar'];, q
        que lo que dice es que este escuchando a un evento llamado eventoFiltrar, y que cuando ocurra este evento,
        llame a una funcion de la clase 'HomeVacantes' llamada 'buscar', la cual va a recibir 3 parametros
        */
        $this->emit('eventoFiltrar', $this->termino, $this->categoria_id, $this->salario_id);
    }
}

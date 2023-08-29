<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class HomeVacantes extends Component {
    public $termino;
    public $categoria_id;
    public $salario_id;
    /*
    !!IMPORTANT

    listeners es indicar que funciones seran llamadas desde una vista o desde otro componente livewire,
    para este ejemplo la funcion buscar tendra que estar escuchando hasta que la llamente externamente, para este ejemplo,
    su llamada no ocurrira directamente en la vista home-vacantes.blade.php, si no dede un hijo suyo, FiltrarVacante.php,
    para este llamado se requieren dos cosas:
    1. que esta clase tenga un metodo que escuhe y este en el array $listeners
    2. que el que llame sea un hijo de este componente y ejecute la linea en ese componente '$this->emit('buscar');'

    */

    // la siguiente linea dice: escuche si algunos de sus componentes hijos o alguien emite un evento llamado , si esto ocurre, llama a la function 'buscar'  de esta clase
    protected $listeners = ['eventoFiltrar'=>'buscar'];

    public function render() {
        $vacantes = Vacante::
                when($this->termino, function($q) {
                    $q->where('titulo', 'LIKE', '%'.$this->termino.'%')
                      ->orWhere('empresa', 'LIKE', '%'.$this->termino.'%');
                })->when($this->categoria_id, function($q) {
                    $q->where('categoria_id', $this->categoria_id);
                })
                ->when($this->salario_id, function($q) {
                    $q->where('salario_id', $this->salario_id);
                })
        ->get();
        // ->toSql();
        // dd($vacantes, $this->salario_id);
        return view('livewire.home-vacantes', compact('vacantes'));
    }

    // esta function la llama el componente hijo, cuando ocurre el submit del archivo filtrar-vacantes.blade.php al un metodo de FiltrarVacantes.php, este emite un evento llamado 'eventoFiltrar' y que es esuchado por 'HomeVacantes' y al ser emitido se debe llamar a buscar
    public function buscar($termino, $categoria_id, $salario_id) {
        // $termino es un string que escribe el usuario para buscar
        $this->termino = $termino;
        $this->categoria_id = $categoria_id;
        $this->salario_id = $salario_id;
    }
}

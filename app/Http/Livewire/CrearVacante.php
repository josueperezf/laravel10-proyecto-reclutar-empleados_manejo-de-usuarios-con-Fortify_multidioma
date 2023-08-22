<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * ESTA CLASE ES COMO SI FUERA UN CONTROLADOR,
 *
 * 1. Debemos definir todos los inputs que va a tener el formulario
 */
class CrearVacante extends Component {
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    use WithFileUploads;

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required|numeric|min:1',
        'categoria' => 'required|numeric|min:1',
        'empresa' => 'required|string',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen' => 'required|image|max:1024|mimes:jpeg,png,jpg,gif',

    ];

    // este metodo es el primero que se llama cuando se carga el componente
    public function render() {
        $salarios = Salario::all();
        $categorias = Categoria::all();
        return view('livewire.crear-vacante', compact('salarios','categorias'));
    }


    /*
        este metodo es llama automaticamente cada vez que un input del formulario cambia,
        esto lo coloque para que valide en tiempo real el input image, para ver si tiene imagen valida,
        lo coloco sobre todo para el renderizado de la imagen cargada
    */
    public function updated($propertyName) {
        $this->validateOnly($propertyName, [
            'imagen' => 'required|image|max:1024|mimes:jpeg,png,jpg,gif',
        ]);
    }


    // este metodo se llama cada vez ejecutan el submit del formulario en el html
    public function guardarVacante() {
        // mandamos a llamar la validacion
        $this->validate();
    }

}

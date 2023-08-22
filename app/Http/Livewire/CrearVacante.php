<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use App\Models\Vacante;
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
    public $cargando = false;
    use WithFileUploads; // esto es obligatorio si queremos adjuntar imagenes o lo que sea mediante livewire

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
        // mandamos a llamar la validacion, si falla no continua ejecutando
        $datosValidados = $this->validate();

        //almacenamos la imagen,
        //->store() es un  metodo de livewire para almacenar imagenes
        // la imagen se guardara en storage/app/public/vacantes
        $rutaImagenAlmacenada = $this->imagen->store('public/vacantes');
        $nombreImagen= str_replace('public/vacantes', '', $rutaImagenAlmacenada);
        // dd($nombreImagen);

        //creamos la vacante
        Vacante::create([
            'categoria_id' => $datosValidados['categoria'],
            'descripcion' => $datosValidados['descripcion'],
            'empresa' => $datosValidados['empresa'],
            'imagen' => $nombreImagen,
            'publicado' => 1,
            'salario_id' => $datosValidados['salario'],// deberia ser salario_id, pero como en el formulario se coloco de nombre salario y no salario_id, entonces se dejo asi
            'titulo' => $datosValidados['titulo'],
            'ultimo_dia' => $datosValidados['ultimo_dia'],
            'user_id' => auth()->user()->id,

        ]);

        // creamos el mensaje
        session()->flash('mensaje', 'La vacante se publico con exito');
        // Redireccionamos
        return redirect()->route('vacantes.index');
    }


    // este metodo lo cree para que cada vez que haga click en el boton submit se llame, con ello deshabilito el boton mientras se hacen las validaciones, se guarda y demas,
    // no utilice el loading normal, ya que este se ejecuta cada vez que el usuario escribe cada letra en los input y no se veria bien desahabilitar el boton submit cuando escriben una letra,
    // asi que lo hice de esta forma y funcionó, este metodo tambien sirve para llamar cosas pesadas y demas
    public function cargador() {
        $this->cargando = false;
        sleep(10);
    }

}

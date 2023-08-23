<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use App\Models\Vacante;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarVacante extends Component {
    public $_id; //la variable no se puede llamar id, ya que livewire utiliza este nombre de manera interna, entonces le colocamos otro y ya, igual es algo solo de uso interno
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva; // esto es un campo auxiliar
    public $cargando = false;
    use WithFileUploads; // esto es obligatorio si queremos adjuntar imagenes o lo que sea mediante livewire

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required|numeric|min:1',
        'categoria' => 'required|numeric|min:1',
        'empresa' => 'required|string',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen_nueva' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif', // imporante: nullable es para que si la variable esta vacia no haga nada, pero si tiene valor entonces aplique las validaciones que estan alli

    ];
    // el siguiente metodo es parte del ciclo de vida y es similar al onInit de angular.
    // el parametro que recibe es es que le enviamos desde la vista resources/view/vacantes/edit.blade.php al hacer el :vacante="$vacante"
    public function mount(Vacante $vacante): void {
        $this->_id = $vacante->id;
        $this->titulo = $vacante->titulo;
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
        $this->empresa = $vacante->empresa;
        $this->ultimo_dia = $vacante->ultimo_dia->format('Y-m-d'); // se coloca ->format('Y-m-d'); porque el input del html espera la fecha en un formato, entonces se lo damos para que dibuje el calendario
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function render() {
        $salarios = Salario::all();
        $categorias = Categoria::all();
        return view('livewire.editar-vacante', compact('salarios','categorias'));
    }
    // este metodo se llama cada vez ejecutan el submit del formulario en el html
    public function editarVacante() {
        // mandamos a llamar la validacion, si falla no continua ejecutando
        $datosValidados = $this->validate(); //datosValidados es un array

        // este bloque try lo coloque yo, porque puede que se trate de guardar la imagen, no se pueda pero igual se almacene data con informacion mala,
        // ademas quiero validar que solo borro la imagen vieja si todo esta bien,
        $mensaje ='';
        try {

            // verificamos si hay una imagen nueva
            //->store() es un  metodo de livewire para almacenar imagenes
            // la imagen se guardara en storage/app/public/vacantes
            if ($this->imagen_nueva) {
                $rutaImagenAlmacenada = $this->imagen_nueva->store('public/vacantes');
                $datosValidados['imagen'] = str_replace('public/vacantes', '', $rutaImagenAlmacenada);
            }

            //buscamos la vacante a editar
            $vacante = Vacante::find($this->_id);
            $vacante->titulo = $datosValidados['titulo'];
            $vacante->salario_id = $datosValidados['salario']; // deberia ser salario_id pero en el formulario se llamo salario
            $vacante->categoria_id = $datosValidados['categoria']; // deberia ser categoria_id pero en el formulario se llamo categoria
            $vacante->empresa = $datosValidados['empresa'];
            $vacante->ultimo_dia = $datosValidados['ultimo_dia'];
            $vacante->descripcion = $datosValidados['descripcion'];
            $vacante->imagen = $datosValidados['imagen'] ?? $vacante->imagen; // si hay imagen nueva la ponemos, si no colocamos la imagen que tenia antes
            $vacante->save();
            $mensaje = 'La vacante se edito con exito';
            // si no hay error al ejecutar el save, ahora si borro la imagen vieja
            if ($this->imagen_nueva && array_key_exists('imagen', $datosValidados)) { // si hay una imagen nueva y la misma se registro en el array de datosValidados, entre al if
                Storage::delete('public/vacantes/'.$this->imagen); //this->imagen es la imagen vieja
            }
        } catch (\Throwable $th) {
            $mensaje = 'OCURRIO UN ERROR AL EDITAR LA VACANTE';
            Log::error(__METHOD__);
            Log::error($th);
        }

        // creamos el mensaje
        session()->flash('mensaje', $mensaje);
        // Redireccionamos
        return redirect()->route('vacantes.index');
    }

    // este metodo lo cree para que cada vez que haga click en el boton submit se llame, con ello deshabilito el boton mientras se hacen las validaciones, se guarda y demas,
    // no utilice el loading normal, ya que este se ejecuta cada vez que el usuario escribe cada letra en los input y no se veria bien desahabilitar el boton submit cuando escriben una letra,
    // asi que lo hice de esta forma y funcionó, este metodo tambien sirve para llamar cosas pesadas y demas
    public function cargador() {
        $this->cargando = false;
    }
}

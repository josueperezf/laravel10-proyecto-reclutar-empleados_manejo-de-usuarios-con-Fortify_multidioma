<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class MostrarVacantes extends Component {
    /**
     * !! Importante
     * si queremos llamar desde el html a un metodo de esta clase php, lo que tenemos que hacer es:
     * 1. crear una variable $listeners y en ella como array colocar el nombre de los metodos que pueden ser llamados, estos seran listener
     * 2. crear el metodo jeje,
     * 3. desde el html, por ejemplo un boton, colocar algo como:
     * <button wire:click="$emit('prueba', {{ $parametro_a_enviar }})" ></button> esta linea de html llama al metodo php llamado 'prueba', sin necesidad de ajax ni nada de eso
     */
    protected $listeners = ['prueba', 'eliminarVacante'];

    // esta clase debe estar en el array $listeners para que pueda ser llamada desde un boton o desde javascript en html
    public function prueba($id) {
        dd($id);
    }

    // esta clase debe estar en el array $listeners para que pueda ser llamada desde un boton o desde javascript en html
    public function eliminarVacante(Vacante $vacante) { // realmente llega el id, pero si le decimos a laravel que sera del tipo vacante, internamente buscara en la base de datos una vacante por es id y me lo asigna a la variable
        try {
            // cree esta variable para tener una referencia a la imagen, y borrarla solamente si se logra borrar la vacante, si no no
            $imagen = $vacante->imagen;
            $vacante->delete();
            if ($imagen) {
                Storage::delete('public/vacantes/'.$imagen); //this->imagen es la imagen vieja
            }
        } catch (\Throwable $th) {
            Log::error("message");
        }
    }
    public function render() {
        $vacantes = Vacante::where('user_id', auth()->user()->id)->paginate(10);
        return view('livewire.mostrar-vacantes', compact('vacantes'));
    }
}

<?php

namespace App\Http\Livewire;

use App\Http\Constantes\RutasStorageUploadsConst;
use App\Models\Candidato;
use App\Models\Vacante;
use App\Notifications\NuevoCandidatoAlEmpleo;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostularVacante extends Component {
    use WithFileUploads; // esto es obligatorio si queremos adjuntar imagenes o lo que sea mediante livewire
    public Vacante $vacante; // esta variable se llena automaticamente, ya que es pasada como parametro en el archivo ver-vacante.blade.php
    public $cv;

    protected $rules = [
        'cv' => 'required|max:3072|mimes:pdf', // no debe pesar mas de 3 megas 1024*3
    ];

    public function postularme() {
        $this->validate();
        // almacenar en el discoduro, 'store' es un metodo que nos ofrece livewire para almacenar archivos
        $rutaCompletaDelCurriculo = $this->cv->store(RutasStorageUploadsConst::CURRICULO);
        // nombre generado por el sistema para el pdf adjuntado, eso lo hace automaticamente
        $nombreCurriculo = str_replace(RutasStorageUploadsConst::CURRICULO, '', $rutaCompletaDelCurriculo);

        // crear el candidato

        // lo podemos hacer de varias manera, la mas facil es: la que esta comentada, la mas profesional es la que deje sin comentar
        // Candidato::create([
        //     "cv" => $nombreCurriculo,
        //     "user_id" => auth()->user()->id,
        //     "vacante_id" => $this->vacante->id,
        // ]);
        $this->vacante->candidatos()->create([
            "cv" => $nombreCurriculo,
            "user_id" => auth()->user()->id,
        ]);


        // crear una notificacion y enviar un email. reclutador es el usuario que creo la vacante. se llama reclutador solo para que se entediera mejor a nivel semantico, pero deberia ser user, solo que en modelo se coloco 'reclutador'
        // ->notify no lo podemos llamar desde cualquier modelo del sistema, es solo para indicar que llamaremos a una NOTIFICACION
        // como reclutador es realmente user, entonces en la tabla notifications, en el campo 'notificable_type' quedara quie la notificacion fue invocada por el modelo 'App\Models\User'
        $this->vacante->reclutador->notify(new NuevoCandidatoAlEmpleo($this->vacante->id, $this->vacante->titulo, auth()->user()->id));

        // mostrar un mensaje session, recordemos que el __() es para que traduzca este texto, todo eso lo coloque yo en el archivo es.json, las traducciones las hice de español a ingles en google
        session()->flash('mensaje', __('Your information was sent successfully'));
        return redirect()->back();

    }
    public function render() {
        return view('livewire.postular-vacante');
    }
}

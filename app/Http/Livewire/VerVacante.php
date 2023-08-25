<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Vacante;
use Livewire\Component;

class VerVacante extends Component {
    // la siguiente liena se carga automaticamente, ya que se recibe como parametro, aunque yo prefiero hacerlo mediante el mount
    public Vacante $vacante;


    // mount es parte del ciclo de vida y es parecido al ngOnInit de angular
    public function mount (Vacante $vacante) {
        $this->vacante = $vacante;
    }

    public function render()
    {
        return view('livewire.ver-vacante');
    }
}

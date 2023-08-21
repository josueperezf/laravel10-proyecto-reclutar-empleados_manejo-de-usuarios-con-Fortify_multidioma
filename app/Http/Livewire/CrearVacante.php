<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CrearVacante extends Component {
    public $salarios = [];

    public function __construct($salarios) {
        $this->$salarios = $salarios;
    }
    public function render() {
        return view('livewire.crear-vacante');
    }
}

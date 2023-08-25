<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use Illuminate\Contracts\View\View;

// los metodos que faltan, como por ejemplo el store lo borramos, ya que esa accion se hara con livewire , especificamente con la clase CrearVacante

class VacanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // AL POLICY NO LE ENVIAMOS EL USUARIO LOGUEADO PORQUE EL LO ACCEDE AUTOMATICAMENTE, LO QUE TENEMOS QUE PASAR  ES SI QUEREMOS ANALIZAR UNA VACANTE EN PARTICULAR O ALGO ASI
        // la sioguiente liena es para indicar que solamente tendra permiso los usuarios de rol 2, los reclutadores de ver el listado de vacantes http://localhost/dashboard
        $this->authorize('viewAny', Vacante::class); // este metodo ya se crea cuando generamos el policy
        return view('vacantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        // AL POLICY NO LE ENVIAMOS EL USUARIO LOGUEADO PORQUE EL LO ACCEDE AUTOMATICAMENTE, LO QUE TENEMOS QUE PASAR  ES SI QUEREMOS ANALIZAR UNA VACANTE EN PARTICULAR O ALGO ASI
        $this->authorize('create', Vacante::class); //create es porque asi se llama el metodo de la clase VacantePolicy
        // la vista vacantes.create llama a un componente 'CrearVacante' que arma el formulario, es ese componente el que le pasa la data para listar categorias y demas
        return view('vacantes.create');
    }


    // LAS VACANTES SOLO LAS PUEDEN VER LOS DESARROLLADORES NO LOS RECLUTADORES, NO ES ALGO TANTO DE LOGICA SI NO PARA QUE SIRVA DE PRACTICA PARA ENTENDER. EN ESTA VISTA ES DONDE EL USUARIO ADJUNTA EL CURRICULO
    public function show(Vacante $vacante) {
        // CUALQUIER PERSONA LOGUEADA O NO PODRA VER UNA VACANTE EN PARTICULAR
        return view('vacantes.show', compact('vacante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vacante $vacante) {
        // AL POLICY NO LE ENVIAMOS EL USUARIO LOGUEADO PORQUE EL LO ACCEDE AUTOMATICAMENTE, LO QUE TENEMOS QUE PASAR  ES SI QUEREMOS ANALIZAR UNA VACANTE EN PARTICULAR O ALGO ASI
        $this->authorize('update', $vacante); // se ejecuta el metodo update del policy VacantePolicy, no hay que decirle el nombre, ya que con el $this, sabe a que modelo pertenece
        return view('vacantes.edit', compact('vacante'));
    }

}

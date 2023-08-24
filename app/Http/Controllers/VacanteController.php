<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// los metodos que faltan, como por ejemplo el store lo borramos, ya que esa accion se hara con livewire , especificamente con la clase CrearVacante

class VacanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vacantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        // la vista vacantes.create llama a un componente 'CrearVacante' que arma el formulario, es ese componente el que le pasa la data para listar categorias y demas
        return view('vacantes.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vacante $vacante) {
        $this->authorize('update', $vacante); // se ejecuta el metodo update del policy VacantePolicy, no hay que decirle el nombre, ya que con el $this, sabe a que modelo pertenece
        return view('vacantes.edit', compact('vacante'));
    }

}

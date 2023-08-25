<?php

namespace App\Policies;

use App\Http\Constantes\RolConst;
use App\Models\User;
use App\Models\Vacante;
use Illuminate\Auth\Access\Response;

class VacantePolicy
{
    // creo este metodo se relaciona siempre al metodo index del controlador, ya la logica la ponemos nosotros, pero debe retornar un bool
    public function viewAny(User $user): bool {
        // si es reclutador si puede ver el panel de mis vacantes http://localhost/dashboard .este metodo lo aplicamos en el controlador 'VacanteController', metodo index
        return $user->rol == RolConst::RECLUTADOR;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vacante $vacante)
    {

    }

    /**
     * Determinar si la usuario puede crear modelos.
     */
    // solo los reclutadores pueden crear vacantes. el internamente toma el usuario logueado
    public function create(User $user): bool {
        return $user->rol == RolConst::RECLUTADOR;
    }

    //* Verificamos si un usuario tiene el permiso de modificar una vacante. puede modificar la vacante solo quien la creó
    public function update(User $user, Vacante $vacante): bool
    {
        return $user->id === $vacante->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vacante $vacante) {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vacante $vacante)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vacante $vacante)
    {
        //
    }
}

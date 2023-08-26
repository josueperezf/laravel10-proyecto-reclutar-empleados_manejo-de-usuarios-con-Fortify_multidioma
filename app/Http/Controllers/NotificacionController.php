<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// este controlador tiene sentido porque almacenamos las notificaciones en la tabla notifications, pero si solo enviaramos correos electronicos para notificar, ya esto no tendria sentido
class NotificacionController extends Controller {

    // el __invoke se utiliza para decir que este controlador no va a tener mas metodos, entonces por default entrara aqui cuando lo llamen
    public function __invoke(Request $request) {
        $notificaciones = auth()->user()->unreadNotifications;

        // para marcar todas las notificaciones como leidas, esto se registra en la tabla notifications,
        auth()->user()->unreadNotifications->markAsRead();

        return view('notificaciones.index', compact('notificaciones'));
    }
}

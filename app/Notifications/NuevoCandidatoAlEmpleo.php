<?php

namespace App\Notifications;

use Faker\Core\Number;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoCandidatoAlEmpleo extends Notification
{
    use Queueable;
    public $vacante_id;
    public $titulo_vacante;
    public $user_id_postulante;

    // son los parametros que nos envian cuando se quiere invocar la notificacion
    public function __construct($vacante_id, $titulo_vacante, $user_id_postulante) {
        $this->vacante_id = $vacante_id;
        $this->titulo_vacante = $titulo_vacante;
        $this->user_id_postulante = $user_id_postulante;
    }

    // es un array donde indicamos que tantas acciones se haran con esta notificacion, que si enviar mail, enviar mensaje de texto al telefou otras opciones
    // para este ejemplo la notificaion se enviara por email, y se enviara por base de datos
    // los parametros del email se configuran en el metodo 'toMail' y la base de datos lo configuramos en 'toDatabase', si no lo tiene cuando creamos esta clase, pues lo creamos a mano
    public function via(object $notifiable): array {
        // return ['mail'];
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/notificaciones/'.$this->vacante_id);
        return (new MailMessage)
                    ->line('Has recibido un nuevo candidato para tu vacante laboral.')
                    ->line('La vacante es: '.$this->titulo_vacante)
                    ->action('Ver notificaciones', $url) //es por si queremos colocar un enlace o algo asi
                    ->line('Gracias por utilizar nuestra aplicacion!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    // almacena las notificaciones en la base de datos
    public function toDatabase(object $notifiable) {
        /*
            lo que coloquemos en este arreglo internamente laravel lo va a convertir en json,
            y lo va almacenar en la tabla notifications en la columna 'data'
        */
        return [
            'vacante_id' => $this->vacante_id,
            'titulo_vacante' => $this->titulo_vacante,
            'user_id_postulante' => $this->user_id_postulante,

        ];
    }
}

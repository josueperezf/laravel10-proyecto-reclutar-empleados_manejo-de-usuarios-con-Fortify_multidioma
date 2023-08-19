<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    // IMPORTANTE AQUI VA EL TEXTO QUE SE ENVIA POR CORREO O EMAIL PARA VERIFICAR CUENTA DE USUARIO DESPUES DE INICIAR SESION
    public function boot(): void
    {
        // lo siguiente lo podemos colocar directamente en español, pero es bien colocarlo en ingles por si se necesita, la traduccion esta en el archivo lang/es.json
        VerifyEmail::$toMailCallback = function($notifiable, $verificationUrl) {
            return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->greeting(Lang::get("Hello") .' '. $notifiable->name)
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify now'), $verificationUrl)
            ->line(Lang::get('If you did not create an account, no further action is required.'))
            ->salutation(new HtmlString(
            Lang::get("Regards.").'<br>' .'<strong>'. Lang::get("Our Team") . '</strong>'
            ));
        };

    }
}

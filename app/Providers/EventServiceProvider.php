<?php

namespace App\Providers;

use App\Events\Actualizaprestamos;
use App\Events\ActualizarprestamospagorEvent;
use App\Events\Clienteregistra;
use App\Events\ELIMINARCLIENTE;
use App\Events\EliminarclienteEvent;
use App\Events\Notificacion;
use App\Events\prestamocancelarEvent;
use App\Events\prestamoEvent;
use App\Events\RegistraEvent;
use App\Events\users\userseliminarevent;
use App\Events\users\UsersregistraEvent;
use App\Listeners\ActualizarprestamoListener;
use App\Listeners\ActualizarprestamospagorListener;
use App\Listeners\ActualizarprestamospagorusersListener;
use App\Listeners\ClienteliminarListener;
use App\Listeners\ClienteregistraListener;
use App\Listeners\ClienteregistrausersListener;
use App\Listeners\EliminarclientListener;
use App\Listeners\PrestamoclientcancelarListener;
use App\Listeners\PrestamoclientcancelarusersListener;
use App\Listeners\PrestamoListener;
use App\Listeners\PrestamousersListener;
use App\Listeners\RegistraclientListener;
use App\Listeners\RegistrausersListener;
use App\Listeners\SendNotification;
use App\Listeners\users\userseliminarlistener;
use App\Listeners\users\UsersregistraenviaListener;
use App\Listeners\users\UsersregistraListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Notificacion::class => [
            SendNotification::class,
        ],

        prestamoEvent::class => [
            PrestamoListener::class,
            PrestamousersListener::class,
        ],

        prestamocancelarEvent::class => [
            PrestamoclientcancelarListener::class,
            PrestamoclientcancelarusersListener::class,
        ],

        RegistraEvent::class=>[
            RegistrausersListener::class,
            RegistraclientListener::class
        ],
        ELIMINARCLIENTE::class=>[
            EliminarclientListener::class
        ],

        ActualizarprestamospagorEvent::class=>[
            ActualizarprestamospagorListener::class,
            ActualizarprestamospagorusersListener::class
        ],
        Actualizaprestamos::class=>[
            ActualizarprestamoListener::class
        ],

        Clienteregistra::class=>[

            ClienteregistraListener::class,
            ClienteregistrausersListener::class
        ],

        EliminarclienteEvent::class=>[
            ClienteliminarListener::class
        ],

        userseliminarevent::class=>[
            userseliminarlistener::class
        ],
        UsersregistraEvent::class=>[
            UsersregistraenviaListener::class,
            UsersregistraListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

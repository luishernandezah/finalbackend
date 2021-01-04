<?php

namespace App\Listeners\users;

use App\Mail\users\RegistraUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UsersregistraenviaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        return   Mail::to(auth()->user()->email)->send(new RegistraUsers($event));

        //
    }
}

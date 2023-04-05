<?php

namespace App\Providers;

use App\Providers\HandoverTicketMovementEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandoverTicketMovementEventListener
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
     * @param  \App\Providers\HandoverTicketMovementEvent  $event
     * @return void
     */
    public function handle(HandoverTicketMovementEvent $event)
    {
        //
    }
}

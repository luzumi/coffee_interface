<?php

namespace App\Listeners;

use App\Events\IncomingUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GetNewUserInterface
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IncomingUserEvent $event): void
    {
        //
    }
}

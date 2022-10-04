<?php

namespace App\Listeners;

use App\Events\OrderSubmited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OnOrderSubmited
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
     * @param  \App\Events\OrderSubmited  $event
     * @return void
     */
    public function handle(OrderSubmited $event)
    {
        //
    }
}

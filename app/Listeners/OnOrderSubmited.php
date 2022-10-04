<?php

namespace App\Listeners;

use App\Events\OrderSubmited;
use App\Jobs\BrewCafe;
use App\Models\Drink;
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
        $items = $event->order->getItems();

        if (!is_array($items[Drink::TYPE])){
            return;
        }

        foreach($items[Drink::TYPE] as $drinkId => $numberOfCups) {
            for($i = 1; $i<= $numberOfCups; $i++) {
                BrewCafe::dispatch(
                    Drink::find($drinkId),
                    $event->order->getId()
                );
            }
        };

    }
}

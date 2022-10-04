<?php

use App\Jobs\BrewCafe;
use App\Models\Drink;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

uses(Tests\TestCase::class, RefreshDatabase::class);

// czy zamowienie mozna zamienic na kolejke napojow do realizacji
test('can manager split order to jobs', function () {
    $order = new Order();
    $order->add(Drink::factory()->create());
    $order->submit();

    Bus::fake();

    $items = $order->getItems();
    foreach($items as $drinkId => $numberOfCups) {
        for($i = 1; $i<= $numberOfCups; $i++) {
            BrewCafe::dispatch(
                Drink::find($drinkId),
                $order->getId()
            );
        }
    };

    Bus::assertDispatched(BrewCafe::class);
});

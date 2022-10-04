<?php

use App\Jobs\BrewCafe;
use App\Jobs\CutCake;
use App\Models\Cake;
use App\Models\Drink;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

uses(Tests\TestCase::class, RefreshDatabase::class);

// czy zamowienie mozna zamienic na kolejke napojow do realizacji
test('can manager split order to jobs', function () {
    Bus::fake();

    $order = new Order();
    $order->add(Drink::factory()->create());
    $order->add(Cake::factory()->create());
    $order->submit();


    $items = $order->getItems();
    $coffees = $items[Drink::TYPE] ?? [];
    $cakes = $items[Cake::TYPE] ?? [];

    foreach($coffees as $drinkId => $numberOfCups) {
        for($i = 1; $i<= $numberOfCups; $i++) {
            BrewCafe::dispatch(
                Drink::find($drinkId),
                $order->getId()
            );
        }
    };

    foreach ($cakes as $cakeId => $numberOfPieces) {
        for($i = 1; $i<= $numberOfPieces; $i++) {
            CutCake::dispatch(
                Cake::find($cakeId),
                $order->getId()
            );
        }
    }

    Bus::assertDispatched(BrewCafe::class);
});

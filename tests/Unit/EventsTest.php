<?php

use App\Events\OrderCompleted;
use App\Events\OrderSubmited;
use App\Models\Order;
use Illuminate\Support\Facades\Event;
use App\Jobs\BrewCafe;
use App\Listeners\OnOrderCompleted;
use App\Listeners\OnOrderSubmited;
use App\Models\Drink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

uses(Tests\TestCase::class, RefreshDatabase::class);

// czy wysylane jest powiadomienie do managera o gotowym zamowieniu do procesowania ?
test('is submit event created', function () {
    Event::fake();

    $order = new Order();
    $order->add(Drink::factory()->create());
    $order->submit();

    Event::assertDispatched(OrderSubmited::class);
});


// czy jest listener czekajacy na powiadomienie o gotowym zamowieniu ?
test('is there any listener on submit order', function() {
    Event::fake();

    $order = new Order();
    $order->add(Drink::factory()->create());
    $order->submit();

    Event::assertListening(OrderSubmited::class, OnOrderSubmited::class);
});

// czy wysylane jest powiadomienie/notifikacja/broadcast po zakonczonym zamowieniu ?
test('is completed event created', function () {
    Event::fake();

    $order = new Order();
    $order->add(Drink::factory()->create());
    $order->submit();
    $order->oneDone();

    Event::assertDispatched(OrderCompleted::class);
});


// czy jest listener czekajacy na powiadomienie o skompletowanym/zakonczonym zamowieniu ?
test('is there any listener on completed order', function() {
    Event::fake();

    $order = new Order();
    $order->add(Drink::factory()->create());
    $order->submit();
    $order->oneDone();

    Event::assertListening(OrderCompleted::class, OnOrderCompleted::class);
});

<?php

use App\Jobs\BrewCafe;
use App\Models\Drink;
use App\Models\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

uses(Tests\TestCase::class, RefreshDatabase::class);

// czy parzenie kawy trwa tak dlugo jak zakladano ?
test('is worker busy proper amount of time', function() {
    $order = new Order();
    $drink = Drink::factory()->create();
    $order->add($drink);
    $order->submit();

    $job = new BrewCafe($drink,$order->id);

    $start = time();
    $job->handle();
    $end = time();

    expect(round($end-$start))->toBe(round($drink->getBrewingTime()));
})->skip(env('LONG_TESTING', true), "this takes too long");

// czy zakonczenie parzenia skutkuje zmniejszeniem ilosci kaw w zamowieniu ?
test('does worker affects amount of coffees left to process', function() {
    $order = new Order();
    $drink = Drink::factory()->create();
    $order->add($drink);
    $order->submit();

    $job = new BrewCafe($drink,$order->id);
    $job->handle();

    $orderChanged = Order::find($order->getId());

    expect($orderChanged->getItemsLeft())->toBe(0);
})->skip(env('LONG_TESTING', true), "this takes too long");

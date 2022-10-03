<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\User;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('can I create Order for User', function () {

    $order = new Order(User::factory()->create());

    expect($order->getStatus() === Order::NEW_ORDER)
        ->toBeTrue();
});

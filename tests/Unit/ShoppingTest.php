<?php

use App\Shopping\Mailer;
use App\Shopping\PayPalGateway;
use App\Shopping\ShoppingCard;
use Tests\FakeGateway;

uses(
    Tests\TestCase::class
);

// czy dostajemy numer paragonu z PayPala
test('test paypal gateway', function() {

    $recipt = '112233';

    // $payments = $this->createMock(PayPalGateway::class);
    // $payments->method('charge')
    //     ->willReturn('receipt: 123');

    $payments = new FakeGateway();

    $status = $payments->charge($recipt);

    expect($status)->toBe('receipt: '.$recipt);
})->group('now');

// cczy mailer dziala\
test('mailer gateway', function() {

    $mailer = $this->createMock(Mailer::class);
    $mailer
        ->expects($this->once())
        ->method('deliver')
        ->willReturn('receipt: 123');

    $mailer->deliver('email@email.com', 'message');

})->group('now');

// czy ShoppingCard dziala
test('shopping card', function() {

    $mailer = $this->createMock(Mailer::class);

    $cart = new ShoppingCard(
        new FakeGateway(),
        $mailer
    );

    $status = $cart->submit();

    expect($status)->toBeTrue();
})->group('now');

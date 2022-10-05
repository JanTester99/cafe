<?php

namespace App\Shopping;


class ShoppingCard extends Card {

    public function __construct($paymentGateway = null, $mailer = null)
    {
        parent::__construct(
            $paymentGateway ? : new PayPalGateway(),
            $mailer ? : new Mailer()
        );
    }
}
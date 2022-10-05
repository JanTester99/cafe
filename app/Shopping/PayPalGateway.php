<?php

namespace App\Shopping;

class PayPalGateway implements PaymentsInterface {

    public function charge(float $amount): string {

        echo "PAYPAL LONG DISTANCE CALL \n";
        return 'receipt: '.rand(10000, 99999);
    }
}
<?php

namespace Tests;

use App\Shopping\PaymentsInterface;

class FakeGateway implements PaymentsInterface {

    public function charge(float $amount): string {
        return 'receipt: '.$amount;
    }
}
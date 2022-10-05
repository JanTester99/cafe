<?php

namespace App\Shopping;

interface PaymentsInterface {

    public function charge(float $amount): string;
}
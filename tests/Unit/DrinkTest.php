<?php

use App\Models\Drink;
uses(
    Tests\TestCase::class, 
    Illuminate\Foundation\Testing\RefreshDatabase::class
);

beforeEach(function() {
    $this->drink = Drink::factory()->make();
});

test('if a Drink has a Price ?', function () {
  
    expect($this->drink->getPrice() >= 0)->toBeTrue();
    expect($this->drink->getBrewingTime() > 0)->toBeTrue();
    expect($this->drink->getName() != '')->toBeTrue();
});
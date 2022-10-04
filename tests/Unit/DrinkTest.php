<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Drink;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function() {
    $this->drink = Drink::factory()->make();
});

test('if drink has a Price ?', function () {
  
    expect($this->drink->getPrice() >= 0)->toBeTrue();
    expect($this->drink->getBrewingTime() > 0)->toBeTrue();
    expect($this->drink->getName() != '')->toBeTrue();
});
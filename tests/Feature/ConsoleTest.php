<?php

use App\Models\Drink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\User;

uses(Tests\TestCase::class, RefreshDatabase::class);



// - [x] czy moge wyswietlic/pobrac liste drinkow/menu ?
test('can I display Drink Menu by Console Command', function () {
    
    $this->artisan('show:menu')->assertSuccessful();
});


// - [ ] czy moge zobaczyc liste niezrealizowanych zamowien ?
test('can I display not Completed Orders', function () {
    $this->artisan('show:orders')->assertSuccessful();
});

<?php

use App\Models\User;

uses(
    Tests\TestCase::class, 
    Illuminate\Foundation\Testing\RefreshDatabase::class
);


test('if user has a name', function () {
    
    $user = User::factory()->make();

    expect($user->getName() !== '')->toBeTrue();
});

<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(Tests\TestCase::class, RefreshDatabase::class);


test('if user has a name', function () {
    
    $user = User::factory()->make();

    expect($user->getName() !== '')->toBeTrue();
});

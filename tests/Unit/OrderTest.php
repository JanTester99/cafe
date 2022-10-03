<?php

use App\Models\Drink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\User;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function() {
    $this->order = new Order(User::factory()->create());
});

// czy moge przypisac uzytkownika do zamowienia ?
test('can I create Order for User', function () {
    expect($this->order->getStatus() === Order::NEW_ORDER)
        ->toBeTrue();
});

// czy moge dodac drink do zamowienia ?
test('if Drink can be added to Order', function(){
    $drink = Drink::factory()->create();
    $this->order->add($drink);
    expect($this->order->getItemsLeft() === 1)->toBeTrue();
});

// czy zamowienie moze zawierac drink ?
test('if order can contain a Drink', function() {
    $this->order->add(Drink::factory()->create());
    expect($this->order->getItemsLeft() > 0)->toBeTrue();
});

// czy zamowienie moze zawierac wiele drinkow ?
test('if order can contain many Drinks', function() {
    $counter = rand(10,20);
    for($i=0; $i< $counter; $i++) {
        $this->order->add(Drink::factory()->create());
    }
    expect($this->order->getItemsLeft() === $counter)->toBeTrue();
});

// czy ilosc kaw do zrobienia, rowna jest ilosci kaw w zamowieniu ?
test('if number of items left in order is the same as order contain ?', function() {
    $counter = rand(10,20);
    for($i=0; $i< $counter; $i++) {
        $this->order->add(Drink::factory()->create());
    }
    $items = $this->order->getItems();
    $itemsCount = 0;
    foreach($items as $drinkId => $numberOfDrinks) {
        $itemsCount += $numberOfDrinks;
    }

    expect($this->order->getItemsLeft() === $itemsCount)->toBeTrue();
});

// czy moge usunac drink z zamowienia
// czy wartosc zamowienia odpowiada cenom drinkow ?
// czy zamowienie jest domyslnie otwarte/niezrealizowane/niewyslane ( do wyboru )
// czy moge wyslac zamowienie puste ?
// czy moge wyslac zamowienie z drinkami ?
// czy zmieni sie status wyslanego zamowienia ?

// czy moge zrealizowac pozycje ( drink / job ) z zamowienia
// czy moge pobrac ilosc napojow pozostalych do zrealizowania w zamowieniu ?
// czy zamowienie ze zrealizowanymi pozycjami jest ukonczone / completed ?


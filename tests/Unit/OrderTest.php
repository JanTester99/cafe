<?php

use App\Models\Drink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\User;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function() {
    $this->order = new Order();
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
test('can I remove Drink from Order', function() {
    $drink = Drink::factory()->create();
    expect($this->order->getItemsLeft())->toBe(0);

    $this->order->add($drink);
    $this->order->add($drink);
    expect($this->order->getItemsLeft())->toBe(2);
    
    $this->order->remove($drink);
    expect($this->order->getItemsLeft())->toBe(1);
});


// czy wartosc zamowienia odpowiada cenom drinkow ?
test('is Order total is exactly sum of ordered drinks prices', function() {
    $total = 0;
    $drink = Drink::factory()->create();

    $this->order->add($drink);
    $total += $drink->getPrice();
    
    $drink = Drink::factory()->create();
    $this->order->add($drink);
    $total += $drink->getPrice();
    
    expect($this->order->getTotal())->toBe($total);
});

// czy zamowienie jest domyslnie otwarte/niezrealizowane/niewyslane ( do wyboru )
test('is new Order with NEW_ORDER as default', function () {
    expect($this->order->getStatus() === Order::NEW_ORDER)
        ->toBeTrue();
});

// czy moge wyslac zamowienie puste ?
test('can I submit empty Order', function() {
    expect($this->order->submit())->toBeFalse();
});


// czy moge wyslac zamowienie z drinkami ?
test('can I submit Order with Drink', function() {
    $this->order->add(Drink::factory()->create());
    expect($this->order->submit())->toBeTrue();
});

// czy zmieni sie status wyslanego zamowienia ?
test('if Order Status is changed when submited', function() {
    $status = $this->order->getStatus();
    $this->order->add(Drink::factory()->create());
    $this->order->submit();

    expect($this->order->getStatus())->not->toBe($status);
});

// czy moge zrealizowac pozycje z zamowienia
test('can I process at least one of Drink from submited Order', function () {
    $this->order->add(Drink::factory()->create());
    $this->order->submit();   
    
    $this->order->oneDone();

    expect($this->order->getItemsLeft())->toBe(0);
});

// czy moge pobrac ilosc napojow pozostalych do zrealizowania w zamowieniu ?
test('can I get Items left from Order', function() {
    $drink = Drink::factory()->create();
    expect($this->order->getItemsLeft())->toBe(0);

    $this->order->add($drink);
    $this->order->add($drink);
    expect($this->order->getItemsLeft())->toBe(2);
});

// czy zamowienie ze zrealizowanymi pozycjami jest ukonczone / completed ?
test('if order with all Drinks delivered has Status Completed', function () {
    $drink = Drink::factory()->create();
    $this->order->add($drink);
    $this->order->add($drink);
    $this->order->submit();
    $this->order->oneDone();
    $this->order->oneDone();
    expect($this->order->getStatus())->toBe(Order::COMPLETED);
});

// czy zamowienie po utworzeniu zostaje zapisane
test('is Order saved to db after create', function() {
    expect(!!$this->order->getId())->toBeTrue();
});

// czy po zmianie zawartosci zamowienie zostaje zaktualizowane
test('is Order saved after contents change', function() {
    $this->order->add(Drink::factory()->create());
    $order = Order::find($this->order->id);

    expect($order->getItemsLeft())->toBe($this->order->getItemsLeft());
});

// czy po wyslaniu do managera zamowienie zostaje zaktualizowane
test('is Order saved after submit', function() {
    $this->order->add(Drink::factory()->create());
    $this->order->submit();

    $order = Order::find($this->order->id);

    expect($order->getStatus())->toBe($this->order->getStatus());
});

// czy po ukonczeniu zamowienie zostaje zaktualizowane
test('is Order saved after completed', function() {
    $this->order->add(Drink::factory()->create());
    $this->order->submit();
    $this->order->oneDone();

    $order = Order::find($this->order->id);

    expect($order->getStatus())->toBe($this->order->getStatus());
});

// czy po utworzeniu zamowienia flagi odpowiadajace za status zostaja ustawione na false
test('are Order flags being set as false with Order create', function() {
    expect($this->order->is_submited)->toBeFalse();
    expect($this->order->is_completed)->toBeFalse();
});

// czy mozna zrealizowac za duzo pozycji
test('can we over process given Order - too much done', function() {
    $this->order->add(Drink::factory()->create());
    $this->order->submit();
    $this->order->oneDone();
    $this->order->oneDone();
    $this->order->oneDone();

    expect($this->order->getItemsLeft())->toBe(0);
});
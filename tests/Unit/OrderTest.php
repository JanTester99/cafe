<?php

use App\Models\Order;
uses(
    Tests\TestCase::class, 
    Illuminate\Foundation\Testing\RefreshDatabase::class
);

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
    $drink = fakeDrink();
    $this->order->add($drink);
    expect($this->order->getItemsLeft() === 1)->toBeTrue();
});

// czy zamowienie moze zawierac drink ?
test('if order can contain a Drink', function() {
    $this->order->add(fakeDrink());
    expect($this->order->getItemsLeft() > 0)->toBeTrue();
});

// czy zamowienie moze zawierac wiele drinkow ?
test('if order can contain many Drinks', function() {
    $counter = rand(10,20);
    for($i=0; $i< $counter; $i++) {
        $this->order->add(fakeDrink());
    }
    expect($this->order->getItemsLeft() === $counter)->toBeTrue();
});

// czy ilosc kaw do zrobienia, rowna jest ilosci kaw w zamowieniu ?
test('if number of items left in order is the same as order contain ?', function() {
    $counter = rand(10,20);
    for($i=0; $i< $counter; $i++) {
        $this->order->add(fakeDrink());
    }
    $items = $this->order->getItems();
    $itemsCount = 0;
    foreach($items as $type => $products) {
        foreach($products as $drinkId => $numberOfItems) {
            $itemsCount += $numberOfItems;
        }
    }

    expect($this->order->getItemsLeft() === $itemsCount)->toBeTrue();
});

// czy moge usunac drink z zamowienia
test('can I remove Drink from Order', function() {
    $drink = fakeDrink();
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
    $drink = fakeDrink();

    $this->order->add($drink);
    $total += $drink->getPrice();
    
    $drink = fakeDrink();
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
    $this->order->add(fakeDrink());
    expect($this->order->submit())->toBeTrue();
});

// czy zmieni sie status wyslanego zamowienia ?
test('if Order Status is changed when submited', function() {
    $status = $this->order->getStatus();
    $this->order->add(fakeDrink());
    $this->order->submit();

    expect($status)->toBe(Order::NEW_ORDER);
    expect($this->order->getStatus())->not->toBe(Order::NEW_ORDER);
});

// czy moge zrealizowac pozycje z zamowienia
test('can I process at least one of Drink from submited Order', function () {
    $this->order->add(fakeDrink());
    $this->order->submit();   
    
    $this->order->oneDone();

    expect($this->order->getItemsLeft())->toBe(0);
});

// czy moge pobrac ilosc napojow pozostalych do zrealizowania w zamowieniu ?
test('can I get Items left from Order', function() {
    $drink = fakeDrink();
    expect($this->order->getItemsLeft())->toBe(0);

    $this->order->add($drink);
    $this->order->add($drink);
    expect($this->order->getItemsLeft())->toBe(2);
});

// czy zamowienie ze zrealizowanymi pozycjami jest ukonczone / completed ?
test('if order with all Drinks delivered has Status Completed', function () {
    $drink = fakeDrink();
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
    $this->order->add(fakeDrink());
    $order = Order::find($this->order->id);

    expect($order->getItemsLeft())->toBe($this->order->getItemsLeft());
});

// czy po wyslaniu do managera zamowienie zostaje zaktualizowane
test('is Order saved after submit', function() {
    $this->order->add(fakeDrink());
    $this->order->submit();

    $order = Order::find($this->order->id);

    expect($order->getStatus())->not->toBe(Order::NEW_ORDER);
});

// czy po ukonczeniu zamowienie zostaje zaktualizowane
test('is Order saved after completed', function() {
    $this->order->add(fakeDrink());
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
    $this->order->add(fakeDrink());
    $this->order->submit();
    $this->order->oneDone();
    $this->order->oneDone();
    $this->order->oneDone();

    expect($this->order->getItemsLeft())->toBe(0);
});

// do zamowienia mozna dodac ciasto
test('can we add Cake to Order', function() {
    $this->order->add($cake = fakeCake());

    expect($this->order->getItemsLeft())->toBe(1);
    expect($this->order->getTotal())->toBe($cake->getPrice());
});

test('if we try to remove Orderable which is not in Order contens', function () {
    $this->order->add(fakeDrink());
    $drink = fakeDrink();
    $state = $this->order->remove($drink);

    expect($state)->toBeFalse();
});
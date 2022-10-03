<?php

test('if drink has a Price ?', function () {
    $drink = Drink::factory()->create();
    expect($drink->getPrice() >= 0)->toBeTrue();
});

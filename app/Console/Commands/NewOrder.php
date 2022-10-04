<?php

namespace App\Console\Commands;

use App\Models\Drink;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;

class NewOrder extends Command
{
    protected $signature = 'neworder';
    protected $description = 'Creates new random order';

    public function handle()
    {
        $order = new Order(User::get()->random());

        $amount = rand(1, 10);

        for($i = 1; $i<= $amount; $i++) {
            $order->add(Drink::get()->random());
        } 

        $order->submit();
    }
}

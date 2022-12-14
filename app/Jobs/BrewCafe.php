<?php

namespace App\Jobs;

use App\Models\Drink;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BrewCafe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $drink;
    private $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Drink $drink, int $orderId)
    {
        $this->drink = $drink;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if (env('APP_ENV') === 'testing') {
            echo "I'm making coffee .. it will take ".$this->drink->getBrewingTime()." seconds \n";
        } else {
            sleep($this->drink->getBrewingTime() ?: 1);
        }
        $order = Order::find($this->orderId);
        $order->oneDone();
    }
}

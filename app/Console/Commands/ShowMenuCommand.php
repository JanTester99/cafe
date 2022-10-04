<?php

namespace App\Console\Commands;

use App\Models\Drink;
use Illuminate\Console\Command;

class ShowMenuCommand extends Command
{
    protected $signature = 'show:menu';
    protected $description = 'Show Drinks menu';

    const HEADERS = ['id', 'name', 'brewing_time', 'price'];

    public function handle()
    {

        $dataset = Drink::get(self::HEADERS)
        ->map(function($drink) {

            $drink->price = number_format($drink->price, 2, ',', ' ');

            return $drink;
        })
        ->toArray();

        $this->table(self::HEADERS, $dataset);
    }
}

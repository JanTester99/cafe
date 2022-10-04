<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ShowOrdersCommand extends Command
{
    protected $signature = 'show:orders';
    protected $description = 'Show Orders';

    const HEADERS = ['id', 'owner_id', 'items_left'];

    public function handle()
    {
        $dataset = Order::where('is_completed', false)
            ->where('is_submited', true)
            ->get(self::HEADERS)
            // ->map(function($order) {

            // })
            ->toArray();

        $this->table(self::HEADERS, $dataset);
    }
}

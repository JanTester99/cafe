<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    public function getPrice(): float 
    {
        return $this->price;
    }

    public function getBrewingTime(): int
    {
        return $this->brewing_time;
    }
}

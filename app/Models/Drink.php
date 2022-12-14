<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model implements Orderable
{
    use HasFactory;

    const TYPE = 'coffee';

    public function getType():string {
        return self::TYPE;
    }

    public function getPrice(): float 
    {
        return $this->price;
    }

    public function getBrewingTime(): int
    {
        return $this->brewing_time;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}


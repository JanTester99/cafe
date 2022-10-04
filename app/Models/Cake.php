<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cake extends Model implements Orderable
{
    use HasFactory;

    const TYPE = 'cake';

    public function getType(): string {
        return self::TYPE;
    }

    public function getPrice(): float 
    {
        return $this->price;
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

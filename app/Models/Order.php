<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const NEW_ORDER = 'nowe';

    public function __construct(User $user)
    {
        $this->owner_id = $user->getId();
    }

    public function getStatus(): string 
    {
        return self::NEW_ORDER;
    }

    public function getItemsLeft(): int
    {
        return $this->items_left ?: 0;
    }

    public function add(Drink $drink): void
    {
        $contents = $this->contents 
            ? json_decode($this->contents, true)  
            : [];
            
        $contents[$drink->getId()] = $contents[$drink->getId()] ?? 0;
        $contents[$drink->getId()] ++;

        $this->items_left ++;
     
        $this->contents = json_encode($contents);
    }
}

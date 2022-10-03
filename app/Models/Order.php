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
}

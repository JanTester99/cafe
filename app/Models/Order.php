<?php

namespace App\Models;

use App\Events\OrderCompleted;
use App\Events\OrderSubmited;
use App\Events\OrderUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const NEW_ORDER = 'nowe';
    const SUBMITED = 'zamowienie przyjete';
    const COMPLETED = 'ukonczone';

    protected $hidden = ['created_at', 'updated_at'];

    public function __construct($user = null)
    {
        if (!($user instanceof User)) {
            $user = User::factory()->create(['name' => 'Guest '.rand(1,100)]);
        }

        $this->owner_id = $user->getId();
        $this->is_completed = false;
        $this->is_submited = false;
        $this->save();
    }

    public function getStatus(): string 
    {
        if (!$this->is_submited) {
            return self::NEW_ORDER;
        }

        if ($this->is_completed && $this->is_submited) {
            return self::COMPLETED;
        }

        return self::SUBMITED;
    }

    public function getItemsLeft(): int
    {
        return $this->items_left ?: 0;
    }

    public function add(Orderable $item): void
    {
        $items = $this->getItems();

        if (!isset($items[$item->getType()])) {
            $items[$item->getType()] = [];
        }
            
        $items[$item->getType()][$item->getId()] = $items[$item->getType()][$item->getId()] ?? 0;
        $items[$item->getType()][$item->getId()] ++;

        $this->items_left ++;
        $this->total += $item->getPrice();
     
        $this->contents = json_encode($items);
        $this->save();
    }

    public function remove(Orderable $item): bool
    {
        $items = $this->getItems();

        // no such item in order
        if (!isset($items[$item->getType()])) {
            return false;
        }
        if (!in_array($item->getId(), array_keys($items[$item->getType()]))) {
            return false;
        }

        if ($items[$item->getType()][$item->getId()] == 1) {
            unset($items[$item->getType()][$item->getId()]);
        } else {
            $items[$item->getType()][$item->getId()] --;
        }

        $this->items_left --;
        $this->total -= $item->getPrice();
        
        $this->contents = json_encode($items);
        $this->save();

        return true;
    }

    public function getItems(): array
    {
        return $this->contents ? json_decode($this->contents, true) : [];
    }

    public function getTotal() {
        return $this->total ?: 0 ;
    }

    public function submit(): bool {

        if (!$this->getItemsLeft()) {
            return false;
        }

        $this->is_submited = true;
        $this->save();
        OrderSubmited::dispatch($this);

        return true;
    }

    public function oneDone():void {

        if ($this->is_completed) {
            return;
        }

        $this->items_left --;
        $this->save();

        if (!$this->items_left) {
            $this->is_completed = true;
            $this->save();
            OrderCompleted::dispatch($this);
        } else {
            OrderUpdated::dispatch($this);
        }
    }

    public function getId(): int
    {
        return $this->id ?? 0;
    }
}

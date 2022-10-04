<?php

namespace App\Models;

use App\Events\OrderCompleted;
use App\Events\OrderSubmited;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const NEW_ORDER = 'nowe';
    const SUBMITED = 'zamowienie przyjete';
    const COMPLETED = 'ukonczone';

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

        if ($this->is_completed) {
            return self::COMPLETED;
        }

        return self::SUBMITED;
    }

    public function getItemsLeft(): int
    {
        return $this->items_left ?: 0;
    }

    public function add(Drink $drink): void
    {
        $items = $this->getItems();
            
        $items[$drink->getId()] = $items[$drink->getId()] ?? 0;
        $items[$drink->getId()] ++;

        $this->items_left ++;
        $this->total += $drink->getPrice();
     
        $this->contents = json_encode($items);
        $this->save();
    }

    public function remove(Drink $drink): void
    {
        $items = $this->getItems();

        // no such drink in order
        if (!in_array($drink->getId(), array_keys($items))) {
            return;
        }

        if ($items[$drink->getId()] == 1) {
            unset($items[$drink->getId()]);
        } else {
            $items[$drink->getId()] --;
        }

        $this->items_left --;
        $this->total -= $drink->getPrice();
        
        $this->contents = json_encode($items);
        $this->save();
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

        if (!$this->items_left) {
            $this->is_completed = true;
            $this->save();
            OrderCompleted::dispatch($this);
        }
    }

    public function getId(): int
    {
        return $this->id ?? 0;
    }
}

<?php

namespace App\Http\Controllers;

use App\Shopping\ShoppingCard;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() {

        $cart = new ShoppingCard();

        $cart->submit();
    }
}

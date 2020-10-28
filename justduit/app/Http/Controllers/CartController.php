<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Shoe $shoe){
        if(auth()->user()->role == 2){
            return view('carts.add', ['shoe' => $shoe]);
        }
    }
}

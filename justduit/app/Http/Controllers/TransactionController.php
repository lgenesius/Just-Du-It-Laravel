<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history(){
        $user_id = auth()->user()->id;
        $cart =  Cart::where('user_id', $user_id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
        dd($cart);
    }
}

<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use App\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Shoe $shoe){
        // dd(auth()->user());
        if(auth()->user()){
            return view('carts.add', ['shoe' => $shoe]);
        }
        abort(401);
    }

    public function store(){
        if(auth()->user()){
            $attr = request()->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            // Cart::create([

            // ]);
        return back();
        }
        abort(401);
    }
}

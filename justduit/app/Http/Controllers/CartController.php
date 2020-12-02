<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use App\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $user = auth()->user();
        // $carts = \DB::table('shoe_user')->where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
        // dd($carts);

        return view('carts.cartIndex', [
            'carts' => \DB::table('shoe_user')->where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get()
        ]);
    }

    public function show(Shoe $shoe){
        // dd(auth()->user());
        if(auth()->user()){
            return view('carts.add', ['shoe' => $shoe]);
        }
        abort(401);
    }

    public function store(Shoe $shoe){
        if(auth()->user()){
            $quantity = request('quantity');
            $user = auth()->user();
            $currCart = Cart::where('user_id', $user->id)->get();

            $attr = request()->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            foreach($currCart as $currCarts){
                if($currCarts->shoe_id == $shoe->id){
                    $finalQuantity = $currCarts-> quantity + $quantity;
                    $shoe->users()->updateExistingPivot($user, array('quantity' => $finalQuantity), true);
                    $carts = Cart::where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
                    return view('carts.cartIndex', compact('carts'));
                }
            }

            $user->shoes()->attach($shoe->id, ['quantity' => request('quantity')]);
            $carts = Cart::where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
            return view('carts.cartIndex', compact('carts'));
        }
        abort(401);
    }

    public function edit(Shoe $shoe){
        return view('carts.cartUpdate', compact('shoe'));
    }

    public function update(Shoe $shoe){
        if(auth()->user()){
            $quantity = request('quantity');
            $user = auth()->user();
            $currCart = Cart::where('user_id', $user->id)->get();

            $attr = request()->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            foreach($currCart as $currCarts){
                if($currCarts->shoe_id == $shoe->id){
                    // dd($quantity);
                    $shoe->users()->updateExistingPivot($user, array('quantity' => $quantity), true);
                    $carts = Cart::where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
                    return view('carts.cartIndex', compact('carts'));
                }
            }

            $user->shoes()->attach($shoe->id, ['quantity' => request('quantity')]);
            $carts = Cart::where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
            return view('carts.cartIndex', compact('carts'));
        }
        abort(401);
    }
}

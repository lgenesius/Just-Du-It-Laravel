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
        return view('carts.cartIndex', [
            'carts' => \DB::table('shoe_user')->where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get(),
            'count' =>  Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count()
        ]);
    }

    public function show(Shoe $shoe){
        // dd(auth()->user());
        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('carts.add', ['shoe' => $shoe, 'count' => $count]);
        }
        abort(401);
    }

    public function store(Shoe $shoe){
        if(auth()->user()){
            $quantity = request('quantity');
            $user = auth()->user();
            $currCart = Cart::where('user_id', $user->id)->get();
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            $attr = request()->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            foreach($currCart as $currCarts){
                if($currCarts->shoe_id == $shoe->id){
                    $finalQuantity = $currCarts-> quantity + $quantity;
                    $shoe->users()->updateExistingPivot($user, array('quantity' => $finalQuantity), true);
                    $carts = Cart::where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
                    session()->flash("success", "{$shoe->name} successfully added into you Cart!");
                    return view('carts.cartIndex', compact('carts', 'count'));
                }
            }

            $user->shoes()->attach($shoe->id, ['quantity' => request('quantity')]);
            $carts = Cart::where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get();
            session()->flash("success", "{$shoe->name} successfully put into you Cart!");
            return redirect('/cartIndex');
        }
        abort(401);
    }

    public function edit(Shoe $shoe){
        $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
        return view('carts.cartUpdate', compact('shoe', 'count'));
    }

    public function update(Shoe $shoe){
        if(auth()->user()){
            $quantity = request('quantity');
            $user = auth()->user();
            $currCart = Cart::where('user_id', $user->id)->get();
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            $attr = request()->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            foreach($currCart as $currCarts){
                if($currCarts->shoe_id == $shoe->id){
                    // dd($quantity);
                    $shoe->users()->updateExistingPivot($user, array('quantity' => $quantity), true);
                    session()->flash("success", "{$shoe->name} successfully updated!");
                    return redirect('/cartIndex');
                }
            }

            $user->shoes()->attach($shoe->id, ['quantity' => request('quantity')]);
            session()->flash("success", "{$shoe->name} successfully updated!");
            return redirect('/cartIndex');
        }
        abort(401);
    }

    public function destroy(Shoe $shoe){
        $shoe->users()->detach();
        // $shoe->delete();
        session()->flash("error", "{$shoe->name} successfully deleted!");
        return redirect('cartIndex');
    }
}

<?php

namespace App\Http\Controllers;

use App\Cart;
use App\DetailTransaction;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function index(){
        $user_id = auth()->user()->id;
        $transactions = Transaction::where('user_id', $user_id)->get();
        return view('transactions.history', compact('transactions'));
    }

    public function checkout(){

        DB::transaction(function () {
            $user = auth()->user();
            $user_id = auth()->user()->id;
            $cart =  Cart::where('user_id', $user_id)->get();

            $transaction = Transaction::create([
                'user_id' => $user_id,
            ]);

            foreach($cart as $carts){
                $transaction->shoes()->attach($carts->shoe_id, ['quantity' => $carts->quantity]);
                // dd($carts);
                $user->shoes()->detach($carts->shoe_id);
            }

        });

        $transactions = Transaction::where('user_id', auth()->user()->id)->get();
        return redirect('transactions');
    }
}

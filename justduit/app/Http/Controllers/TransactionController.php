<?php

namespace App\Http\Controllers;

use App\Cart;
use App\DetailTransaction;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        /**
         * Fungsi ini untuk menampilkan data berdasarkan role user
         * Kalau admin maka semua data history transaksi akan ditampilkan
         * Kalau non-admin dan terlogin usern, maka history transaksi user tersebut akan ditampilkan
         */

        $user_id = auth()->user()->id;
        if(auth()->user()->role == 1){
            $transactions = Transaction::with('shoes')->get();
        }
        else if(auth()->user()->role == 2){
            $transactions = Transaction::with('shoes')->where('user_id', $user_id)->get();
        }
        return view('transactions.history', compact('transactions'));
    }

    public function checkout(){

        /**
         * Fungsi checkout akan membuatkan sebuah header transaction baru untuk user, kemudian untuk setiap data yang ada cart user, akan dimasukkan ke dalam tabel pivot melalui fungsi attach yang sama pada cartController
         * Kemudian datanya akan dihapus pada database, menggunakan fungsi detach
         * Untuk fungsi DB::transaction(function(){}); adalah fungsi bawaan dari laravel
         * https://laravel.com/docs/7.x/database#database-transactions
         * Fungsi ini berguna ketika kita ini mencegah error dan tanpa harus melakukan rollback
         * Misalnya, ketika $transaction sudah dibuat modelnya
         * Lalu pada foreach terjadi error, maka tentu error akan muncul pada layar
         * Tapi, tanpa kita sadari, model transaction sudah terbuat dan terdata pada database, namun tidak mempunyai record data ke pivot table
         * Oleh karena itu, fungsi transaction ini berguna ketika "exception is thrown" maka semua yang dikerjakan di dalam ini akan ter-rollback secara otomatis.
         */

        DB::transaction(function () {
            $user = auth()->user();
            $user_id = auth()->user()->id;
            $cart =  Cart::where('user_id', $user_id)->get();

            $transaction = Transaction::create([
                'user_id' => $user_id,
            ]);

            foreach($cart as $carts){
                $transaction->shoes()->attach($carts->shoe_id, ['quantity' => $carts->quantity]);
                $user->shoes()->detach($carts->shoe_id);
            }

        });

        $transactions = Transaction::where('user_id', auth()->user()->id)->get();
        return redirect('transactions');
    }
}

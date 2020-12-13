<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use App\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        /**
         * Index adalah naming convention standar pada laravel untuk menampilkan "semua" data dari database, sedangkan show untuk menampilkan data2 tertentu saja
         * Fungsi ini digunakan untuk mengambil data dari cart yang sesuai dengan id user yang sedang login
         * Join di sini berfungsi agar kita bisa mengakses semua data yang ada di dalam tabel shoes, yang di mana shoe_id pada cart table akan sesuai dengan id yang ada pada shoe table, sehingga data seperti foto, quantity, dan kolum lain yang ada pada tabel shoe bisa diakses;
         * \DB::table('shoe_user) sama dengan model Cart
         */

        $user = auth()->user();
        return view('carts.cartIndex', [
            'carts' => \DB::table('shoe_user')->where('user_id', $user->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->get(),
            'count' =>  Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count()
        ]);
    }

    public function show(Shoe $shoe){

        /**
         * Menampilkan cart sesuai dengan user_id
         * Join digunakan agar dari pivot table bisa mengakses data-data pada tabel shoes, seperti title, harga, ataupun imagenya
         */

        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('carts.add', ['shoe' => $shoe, 'count' => $count]);
        }
        abort(401);
    }

    public function store(Shoe $shoe){

        /**
         * -Function ini digunakan ketika user ingin store shoes ke dalam cart/database
         * -$count digunakan sebagai cart notification pada side bar
         * -$currCart digunakan untuk mengambil semua data pada PivotTable / Cart (shoe_user table) yang id nya sesuai dengan id user yang sedang login sekarang
         * -Foreach digunakan untuk mengecek apakah id shoe sekarang user ingin beli itu sudah ada di dalam cartnya  atau tidak
         * -Jika sudah ada, maka quantity yang diinput akan bertambah, dan tidak menambahkan row baru, di sini kami menggunakan fungsi updateExistingPivot, merupakan fungsi pada laravel 7, di mana parameter pertama adalah table yang bersebrangan dengan pivot tabel selain shoe, yaitu user, parameter kedua adalah bagian yang ingin diubah, parameter ke tiga yaitu true atau false, jika true maka update_at akan diubah "https://stackoverflow.com/questions/33543897/how-to-update-a-pivot-table-using-eloquent-in-laravel-5" -> masih bekerja di laravel 7
         * Kemudian session flash digunakan untuk memberikan message yang dikirim melalui session
         * Attach merupakan fungsi bawaaan yang bisa digunakan pada relasi Many to Many laravel, di sini attach digunakan untuk menyisipkan data ke dalam table pivot, dan ['quantity] => request('quantity') digunakan untuk menspesifikasikan kolum quantity pada tabel pivot, bahwa kolom quantity tersebut akan diisi quantity dari request HTTP:POST user
         */

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

        /**
         * Sama seperti index tapi dilempar model shoe secara spesifik yang diklik oleh user dan ingin diedit
         */

        $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
        return view('carts.cartUpdate', compact('shoe', 'count'));
    }

    public function update(Shoe $shoe){

        /**
         * Fungsi update ini digunakan ketika user ingin update isi pada cart
         * Fungsinya hampir sama dengan ketika user input pada database
         * Bedanya hanya pada menambahkan quantity atau tidak saja, kalau pada update ini quantity tidak bertambah, namun langsung berganti
        */

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

        /**
         * Fungsi destory adalah naming convention pada laravel ketika ingin mem-perform penghapusan data
         * Di sini tinggal menggunakan detach, yang merupakan fugnsi bawaan untuk menghapus data pada pivot table
         * Sepert atach, detach di sini menghapus data
         */

        $shoe->users()->detach();
        session()->flash("error", "{$shoe->name} successfully deleted!");
        return redirect('cartIndex');
    }
}

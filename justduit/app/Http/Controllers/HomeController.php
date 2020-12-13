<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        /**
         * Index adalah naming convention standar pada laravel untuk menampilkan "semua" data dari database, sedangkan show untuk menampilkan data2 tertentu saja
         * Fungsi ini digunakan untuk mengambil data dari cart yang sesuai dengan id user yang sedang login
         * Join di sini berfungsi agar kita bisa mengakses semua data yang ada di dalam tabel shoes, yang di mana shoe_id pada cart table akan sesuai dengan id yang ada pada shoe table, sehingga data seperti foto, quantity, dan kolum lain yang ada pada tabel shoe bisa diakses, kemudian dicount agar menampilkan data jumlah cart user;
         *
         */

        $shoes = Shoe::orderBy('id','desc')->paginate(6);
        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('shoes.index', compact('shoes', 'count'));
        }
        return view('shoes.index', compact('shoes'));

    }

    public function search(Request $request){

        /**
         * Searching di sini menggunakan ORM Eloquent biasa menggunakan where, namun validasinya menggunakan like, di mana %.$search.% akan mengecek semua angka yang mengandung input/search, misal a, maka BaC akan masuk juga
         * Untuk menampilkan 6 data saja untuk setiap halaman, maka digunakan paginate agar ada angka pada setiap halaman, kalau menggunakan panah saja, maka harus menggunakan simplePaginate
         * Count untuk menampilkan notifikasi jumlah cart user, defaultnya adalah 0 kalau tidak ada, diatur pada blade
         */

        $search = $request->get('search');
        $shoes = Shoe::where('name', 'like', '%'.$search.'%')->orderBy('id','desc')->paginate(6);
        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('shoes.index', compact('shoes', 'count'));
        }
        return view('shoes.index', compact('shoes'));

    }

    public function show(Shoe $shoe){
        /**
         * Menampilkan data/shoe yang diklik oleh user
         * Kalau user terotentikasi maka akan dikirim juga data count
         * Tapi kalau tidak maka tidak akan dikirim, hal ini juga digunakan untuk mencegah error
         */

        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('shoes.show', compact('shoe', 'count'));
        }
        return view('shoes.show', compact('shoe'));
    }
}

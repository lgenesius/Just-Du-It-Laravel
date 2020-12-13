<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use Illuminate\Http\Request;

class ShoesController extends Controller
{
    public function __construct()
    {
        /**
         * Fungsi ini adalah bawaan dari laravel, di mana kita bisa membuat fungsi dibawah fungsi ini tidak bisa dijalankan kalau user tidak ter-otentikasi
         * Namun, kekurangannya adalah "SEMUA FUNGSI" di bawah ini harus terotentikasi, dan mungkin saja ada fungsi tertentu yang bisa diakses oleh non-user
         * Oleh karena itu kita bisa mengaturnya melalui middleware pada web.php pada route kita, dan kita membuatnya dalam grup. Kemudian, di dalam sana kita bisa menspesifikkan dengan fungsi withoutMiddleware('auth') pada route yang tidak membutuhkannya
         * Secara default, ketika user non-login mengakses halaman tertentu yang menggunakan middleware, maka user tersebut akan terlempar dan masuk kembali ke login page.
         */

        $this->middleware('auth');
    }

    public function index(){

        /**
         * Menampilkan data sepatu yang diorder berdasarkan id dari yang paling besar / latest data
         */

        $shoes = Shoe::orderBy('id','desc')->paginate(6);
        $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
        return view('shoes.index', compact('shoes', 'count'));
    }

    public function create(){
        if(auth()->user()->role != 1){
            abort(401);
        }
        return view('shoes.create');
    }

    public function store(){

        /**
         * Fungsi ini digunakan untuk memasukkan data ke dalam database melalui user dengan role 1 yaitu admin saja
         * Data akan divalidasi melalui request yang dikirim melalui HTTP:POST
         * untuk image, bisa menggunakan 2 cara, antara mengaksesnya dari storage public yang dilink pada storage internal menggunakan STORAGE LINK, ataupun image disimpan secara paksa ke storage public saja
         * $imagePath di sini akan menampilkan path yang akan disimpan ke dalam public dan di sini nama foto sudah ter-enkripsi,
         * Jadi misalnya kita upload image image.png
         * Fungsi kita adalah $imagePath = request('image')->store('public') saja
         * Maka $imagePath akan berisi public/3BFxkSxc5EZ4OcabgOA0skKnpRQ76dcfEGNUr86a.png, namanya akan dihash
         * Namun, kita menambahkan pathnya yaitu images, nanti hasil path $imagePath adalah images/3BFxkSxc5EZ4OcabgOA0skKnpRQ76dcfEGNUr86a.png
         * Namun, bedanya, kita akan memasukkan foto tersebut ke dalam folder public, ke dalam folder images
         * Gunanya agar kita bisa memasukkannya ke dalam folder images, yang bisa kita masukkan ke dalam storage link dan diakses melalui public folder
         * Jadinya, image yang diupload akan disimpan ke dalam database beserta pathnya, dan ketika diakses dari blade, kita bisa mengaksesnya mengguankan path image tersebut ditambah dengan tambahan prefix "storage/"
         */

        if(auth()->user()->role != 1){
            abort(401);
        }

        $data = request()->validate([
            'name' => 'required',
            'price' => ['required', 'numeric', 'min:100'],
            'description' => ['required'],
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('images');
        Shoe::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $imagePath,
        ]);

        return redirect('/shoes');
    }

    public function edit(Shoe $shoe){
        if(auth()->user()->role != 1){
            abort(401);
        }

        return view('shoes.edit', compact('shoe'));
    }

    public function update($shoe){

        /**
         * Update shoe ini mirip seperti store
         * Akan ada validasi di mana ketika user tidak memasukkan image, maka image yang dimasukkan akan mengacu pada image yang lama yaitu 'oldImage' yang diselipkan pada blade
         * Setelah itu kita akan mencari shoe yang seusai dengan shoe yang dilempar dari route, lalu mengupdatenya
         * Sebenarnya kita juga bisa langsung $shoe->update([fields])
         */
        if(auth()->user()->role != 1){
            abort(401);
        }

        $data = request()->validate([
            'name' => 'required',
            'price' => 'required|min:100|numeric',
            'description' => 'required',
            'image' => 'image',
        ]);

        if(request('image')){
            $imagePath = request('image')->store('images', 'public');
        }
        else {
            $imagePath = request('oldImage');
        }

        Shoe::find($shoe)->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $imagePath
        ]);

        return redirect('/shoes');
    }
}

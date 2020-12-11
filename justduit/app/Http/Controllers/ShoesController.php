<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Shoe;
use Illuminate\Http\Request;

class ShoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
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
        if(auth()->user()->role != 1){
            abort(401);
        }

        $data = request()->validate([
            'name' => 'required',
            'price' => ['required', 'numeric', 'min:100'],
            'description' => ['required'],
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('images', 'public');

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
        if(auth()->user()->role != 1){
            abort(401);
        }

        $data = request()->validate([
            'name' => 'required',
            'price' => 'required',
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

<?php

namespace App\Http\Controllers;

use App\Shoe;
use Illuminate\Http\Request;

class ShoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $shoes = Shoe::all();

        return view('shoes.index', compact('shoes'));
    }

    public function create(){
        if(auth()->user()->role != 1){
            abort(401);
        }

        return view('shoes.create');
    }

    public function store(){
        $data = request()->validate([
            'name' => 'required',
            'price' => ['required', 'min:100'],
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
}

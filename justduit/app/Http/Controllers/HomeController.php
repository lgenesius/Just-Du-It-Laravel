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
        $shoes = Shoe::orderBy('id','desc')->paginate(6);
        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('shoes.index', compact('shoes', 'count'));
        }
        return view('shoes.index', compact('shoes'));

    }

    public function search(Request $request){
        $search = $request->get('search');
        $shoes = Shoe::where('name', 'like', '%'.$search.'%')->orderBy('id','desc')->paginate(6);
        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('shoes.index', compact('shoes', 'count'));
        }
        return view('shoes.index', compact('shoes'));

    }

    public function show(Shoe $shoe){
        if(auth()->user()){
            $count = Cart::where('user_id', auth()->user()->id)->join('shoes', 'shoe_user.shoe_id', '=', 'shoes.id')->count();
            return view('shoes.show', compact('shoe', 'count'));
        }
        return view('shoes.show', compact('shoe'));
    }
}

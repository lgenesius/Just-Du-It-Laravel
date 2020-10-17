<?php

namespace App\Http\Controllers;

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

        return view('shoes.index', compact('shoes'));
    }

    public function search(Request $request){
        $search = $request->get('search');
        $shoes = Shoe::where('name', 'like', '%'.$search.'%')->orderBy('id','desc')->paginate(6);

        return view('shoes.index', compact('shoes'));
    }

    public function show(Shoe $shoe){

        return view('shoes.show', compact('shoe'));
    }
}

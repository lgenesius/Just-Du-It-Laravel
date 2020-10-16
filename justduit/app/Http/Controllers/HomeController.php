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
        $shoes = Shoe::all();

        return view('shoes.index', compact('shoes'));
    }
}

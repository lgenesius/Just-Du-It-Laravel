@extends('layouts.app')

@section('link-style')
<link rel="stylesheet" href="/css/show-shoe-style.css">
@endsection

@section('content')


<div class="main-body">
    @include('layouts.sidebar')
    <div class="container mt-3">
        <div class="card text-center">
            <div class="card-header bg-primary" style="color: white; font-weight: bold">
              View Cart
            </div>
            <div class="card-body">
            @forelse ($carts as $cart)
                <div class="d-flex justify-content-around align-items-baseline" style="margin: 10em 0 10em 0">
                    <img src="/storage/{{ $cart->image }}" width = "15%" alt="">
                    <p class="card-text">Rp {{$cart->price}}</p>
                    <p class="card-text">{{$cart->quantity}}</p>
                    <p class="card-text">Rp {{$cart->price * $cart->quantity}}</p>
                    <a href="/cartUpdate/{{$cart->shoe_id}}/edit" class="btn btn-primary">Edit</a>
                </div>
            @empty
                <div class="d-flex justify-content-center">
                    <div class="alert alert-info">
                        Your cart is Empty
                    </div>
                </div>
            @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

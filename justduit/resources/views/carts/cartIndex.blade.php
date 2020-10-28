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
                {{-- @forelse ($carts as $cart) --}}
                <div class="d-flex justify-content-around align-items-baseline" style="margin: 10em 0 10em 0">
                    <h5 class="card-title">Image</h5>
                    <p class="card-text">Price</p>
                    <p class="card-text">Quantity</p>
                    <p class="card-text">TotalPrice</p>
                    <a href="/updateCart/}" class="btn btn-primary">Edit</a>
                    {{-- {{$CartDetails->id} --}}
                </div>

                <div class="d-flex justify-content-around align-items-baseline" style="margin: 10em 0 10em 0">
                    <h5 class="card-title">Image</h5>
                    <p class="card-text">Price</p>
                    <p class="card-text">Quantity</p>
                    <p class="card-text">TotalPrice</p>
                    <a href="#" class="btn btn-primary">Edit</a>
                </div>

                <div class="d-flex justify-content-around align-items-baseline" style="margin: 10em 0 10em 0">
                    <h5 class="card-title">Image</h5>
                    <p class="card-text">Price</p>
                    <p class="card-text">Quantity</p>
                    <p class="card-text">TotalPrice</p>
                    <a href="#" class="btn btn-primary">Edit</a>
                </div>

            {{-- @empty
                <div class="d-flex justify-content-center">
                    <div class="alert alert-info">
                        Your cart is Empty
                    </div>
                </div>
            @endforelse --}}

            </div>
          </div>
    </div>
</div>

@endsection

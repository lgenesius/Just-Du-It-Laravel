@extends('layouts.app')

@section('link-style')
<link rel="stylesheet" href="/css/show-shoe-style.css">
@endsection

@section('content')


<div class="main-body">
    @include('layouts.sidebar')
    <div class="container mt-3">
        @include('alert')
        <div class="card text-center">
            <div class="card-header bg-primary" style="color: white; font-weight: bold">
              View Cart
            </div>
            <div class="card-body">
                <table class="table">
                    @if (!$carts->isEmpty())
                        <thead class="thead">
                            <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                    @else

                    @endif
                    <tbody>
                        @forelse ($carts as $cart)
                            <tr>
                                <td><img src="/storage/{{ $cart->image }}" width = "300px" alt=""></td>
                                <td><p class="card-text">{{$cart->name}}</p></td>
                                <td><p class="card-text">{{$cart->quantity}}</p></td>
                                <td><p class="card-text">Rp {{$cart->price * $cart->quantity}},-</p></td>
                                <td><a href="/cartUpdate/{{$cart->shoe_id}}/edit" class="btn btn-primary">Edit</a></td>
                            </tr>
                        @empty
                            <div class="d-flex justify-content-center">
                                <div class="alert alert-info">
                                    Your cart is Empty
                                </div>
                            </div>
                        @endforelse
                    </tbody>
                </table>
                <a href="" class="btn btn-primary {{$carts->isEmpty() ? 'disabled' : ''}}" style="width: 50%; margin-top:20px">Checkout</a>
            </div>
        </div>
    </div>
</div>

@endsection

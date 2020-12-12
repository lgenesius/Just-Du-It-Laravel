@extends('layouts.app')

@section('link-style')
<link rel="stylesheet" href="/css/show-shoe-style.css">
<link rel="stylesheet" href="/css/cart-style.css">
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
                <div class="table-responsive">
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
                                    <td>
                                        <a href="/shoes/{{ $cart->shoe_id }}" target="_blank">
                                            <img src="/storage/{{ $cart->image }}" width = "300px" alt="">
                                        </a>
                                    </td>
                                    <td class="align-middle"><p class="card-text">{{$cart->name}}</p></td>
                                    <td class="align-middle"><p class="card-text">{{$cart->quantity}}</p></td>
                                    <td class="align-middle"><p class="card-text">Rp {{$cart->price * $cart->quantity}},-</p></td>
                                    <td class="align-middle"><a href="/cartUpdate/{{$cart->shoe_id}}/edit" class="btn btn-primary">Edit</a></td>
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
                </div>
                <a href="/transaction" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary {{$carts->isEmpty() ? 'disabled' : ''}} checkout">Checkout</a>

                <div class="container">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda ingin Checkout?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="height: 450px;">
                                    <div class="mb-2 cart-container" style="overflow-y: scroll; max-height: 100%">
                                        <div class="container">
                                            @foreach ($carts as $cart)
                                                <div class="row text-center">
                                                    <div class="col-md-6">
                                                        <a href="/shoes/{{ $cart->shoe_id }}" target="_blank">
                                                            <img class="img-checkout" width="150px" height="150px" style="object-fit: cover" src ="/storage/{{ $cart->image }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{$cart->name}}
                                                        <small>
                                                            <div class="text-secondary">
                                                                Price: Rp {{$cart->price * $cart->quantity}},00
                                                            </div>
                                                        </small>
                                                    </div>
                                                </div>
                                                @if (!$loop -> last)
                                                    <hr>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                    <div class="container">
                                        <div class="d-flex mb-3 justify-content-center">
                                            {{-- <a href="/transaction/checkout" class="nav-link">Checkout</a> --}}
                                            <button class="btn btn-primary mr-3" type="submit">
                                                <a href="/transaction/checkout" style="text-decoration: none; color: white">Checkout</a>
                                            </button>
                                            <button class="btn btn-danger" type="submit" data-dismiss="modal">Tidak</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

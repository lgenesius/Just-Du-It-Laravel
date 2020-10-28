@extends('layouts.app')

@section('link-style')
<link rel="stylesheet" href="/css/show-shoe-style.css">
@endsection

@section('content')
<div class="main-body">
    @include('layouts.sidebar')
    <div class="shoes-data-section">
        <div class="show-shoe-section">
            <div class="show-shoe-image">
                <img src="/storage/{{$shoe->image}}">
                @guest

                @else
                    @if (auth()->user()->role == 2)
                <div class="d-flex justify-content-start">
                    <label class = "d-flex align-items-center" for="quantity" style="margin-right: 1em">Quantity</label>
                    <input style = "width: 12em"type="text" name="quantity" placeholder = "{{old('quantity') ?? 0}}" id="quantity" class="form-control @error('quantity') is-invalid @enderror">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                    <a href="/carts/{{$shoe->id}}/add" class="mt-2 btn btn-primary">Add to Cart</a>

                    @else
                        <a href="/shoes/{{$shoe->id}}/edit" class="mt-2 btn btn-primary">Update Shoe</a>
                    @endif
                @endguest
            </div>
            <div class="show-shoe-text">
                <h2>{{$shoe->name}}</h2>
                <h3>Price : Rp {{$shoe->price}},00</h3>
                <div class="show-shoe-description mt-3">
                    <h4>Description :</h4>
                    <h4>{{$shoe->description}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

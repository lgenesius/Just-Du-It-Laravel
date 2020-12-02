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
                <form action="/addToCart/{{$shoe->id}}" method="POST">
                        @csrf

                        <div class="d-flex justify-content-start flex-wrap" style="width: 17em">
                            <label class = "d-flex align-items-center" for="quantity" style="margin-right: 1em">Quantity</label>
                            <input style = "width: 12em" type="number" name="quantity" placeholder = "{{old('quantity') ?? 0}}" id="quantity" class="form-control @error('quantity') is-invalid @enderror">
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    @if (auth()->user()->role == 2)
                    <button class="mt-3 btn btn-primary" type="submit">Add to Cart</button>

                    @else
                        <a href="/shoes/{{$shoe->id}}/edit" class="mt-2 btn btn-primary">Update Shoe</a>
                    @endif
                </form>
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

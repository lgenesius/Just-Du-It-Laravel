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
                    <a href="/addToCart/{{$shoe->id}}" class="mt-2 btn btn-primary">Add to Cart</a>

                    @else
                        <a href="/shoes/{{$shoe->id}}/edit" class="mt-2 btn btn-primary">Update Shoe</a>
                    @endif
                @endguest
            </div>
            <div class="show-shoe-text">
                <h2>{{$shoe->name}}</h2>
                <h3>Price : Rp {{$shoe->price}},-</h3>
                <div class="show-shoe-description mt-3">
                    <h4>Description :</h4>
                    <h5 style="font-weight: lighter; text-align: justify">{{$shoe->description}}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

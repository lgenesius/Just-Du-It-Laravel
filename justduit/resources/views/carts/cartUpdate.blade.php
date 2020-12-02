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
                <img src="/storage/{{$shoe->image}}" class="img-fluid" alt="Responsive image">
            </div>
            <div class="show-shoe-text">
                <div class="d-flex flex-column justify-content-between" style="height: 400px">
                    <div>
                        <h2>{{$shoe->name}}</h2>
                        <h3>Price : Rp {{$shoe->price}},00</h3>
                        <div class="show-shoe-description mt-3">
                            <h4>Descriptions :</h4>
                            <h4>{{$shoe->description}}</h4>
                        </div>
                    </div>
                    <div>
                        @guest
                        @else
                        <div class="my-4">
                            <form action="/cartUpdate/{{$shoe->id}}/edit" method="POST">
                                @method('patch')
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
                            <div class="d-flex align-items-baseline justify-content-around">
                                <button class="mt-3 btn btn-primary" type="submit">Update</button>
                                <a class=".text-info" type="submit" style="text-decoration: none">Delete</a>
                            </div>
                        </form>
                        </div>
                    @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

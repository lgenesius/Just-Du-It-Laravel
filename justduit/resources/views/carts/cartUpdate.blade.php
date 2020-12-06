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
                        <div class="d-flex mt-4">
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
                                <button class="mt-3 btn btn-primary mt-4" type="submit">Update</button>
                            </form>
                        </div>
                        <div class="mt-3">
                            <a class=".text-info btn" data-toggle="modal" style="text-decoration: none; background: red; color: white" data-target="#exampleModal">Delete</a>
                            <div class="container">
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Apakah Anda ingin menghapus?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <div>{{$shoe->name}}</div>
                                                <small>
                                                    <div class="text-secondary">
                                                        Price: Rp {{$shoe->price}},00
                                                </small>
                                            </div>
                                            </div>
                                            <form action="/cartUpdate/{{$shoe->id}}/delete" method="post">
                                                @csrf
                                                @method("delete")
                                                <div class="d-flex">
                                                    <button class="btn btn-danger mr-3" type="submit">Ya</button>
                                                    <button class="btn btn-success" type="submit" data-dismiss="modal">Tidak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

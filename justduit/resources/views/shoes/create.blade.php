@extends('layouts.app')

@section('link-style')
<link rel="stylesheet" href="/css/create-shoe-style.css">
@endsection

@section('content')
    <div class="main-body">
        @include('layouts.sidebar')
        <div class="shoes-data-section">
            <div class="create-shoe-section">
                <form action="/shoes" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="text-center">
                        <h1>Add New Shoe</h1>
                    </div>

                    <div class="form-group row mt-4">
                        <label for="name" class="col-md-4 col-form-label">Shoe Name</label>

                        <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="price" class="col-md-4 col-form-label">Price</label>

                        <input type="number" id="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}">

                        @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label">Description</label>

                        <input type="text" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}">

                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <label for="image" class="col-md-4 col-form-label">Image</label>

                        <input type="file" class="form-control-file" id="image" name="image">

                        @if ($errors->has('image'))
                            <strong>{{ $errors->first('image') }}</strong>
                        @endif
                    </div>

                    <div class="row pt-4">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

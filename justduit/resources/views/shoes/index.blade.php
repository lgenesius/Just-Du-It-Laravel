@extends('layouts.app')

@section('link-style')
<link rel="stylesheet" href="/css/index-shoe-style.css">
@endsection

@section('content')
    <div class="main-body">
        @include('layouts.sidebar')
        <div class="shoes-data-section">
            <div class="index-shoe-section">
                <div class="row">
                    <h1>View Shoes</h1>
                </div>
                @if(count($shoes) > 0)
                    <div class="row index-shoe-body">
                        @foreach ($shoes as $shoe)
                            <a href="/shoes/{{ $shoe->id }}" class="mt-1">
                                <div class="index-shoe-detail">
                                    <div class="index-shoe-image">
                                        <img src="/storage/{{ $shoe->image }}">
                                    </div>
                                    <h5 class="mt-2">{{ $shoe->name }}</h5>
                                    <h5>Rp {{ $shoe->price }},-</h5>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="row no-result">
                        <h1>Sorry!</h1>
                        <h2>There is no result.</h2>
                        <h3>What you search was unfortunately not found or doesn't exist.</h3>
                    </div>
                @endif
                <div class="row mt-5">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $shoes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

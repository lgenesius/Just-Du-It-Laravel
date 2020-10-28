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
              View All Transaction
            </div>
            <div class="card-body">
                {{-- @foreach ($transactions as $transaction) --}}
                <div class="d-flex justify-content-center">
                    <div class="alert alert-primary px-5">
                        <div class="d-flex justify-content-baseline">
                            <p> $transaction->created_at->format("Y-F-D")}} </p>
                            <p> Total Rp {$transaction->transactionTotal}</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-baseline my-5">
                    {{-- @foreach ($transactions as $transaction) --}}
                    <h5 class="card-title mx-3">Image1</h5>
                    <h5 class="card-title mx-3">Image2</h5>
                    <h5 class="card-title mx-3">Image3</h5>
                    {{-- @endforeach --}}
                </div>
                {{-- @endforeach --}}
            </div>
          </div>
    </div>
</div>

@endsection

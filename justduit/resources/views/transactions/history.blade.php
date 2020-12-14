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
                @forelse($transactions as $transaction)
                <div class="d-flex justify-content-center">
                    <div class="alert alert-primary px-5">
                        <div class="d-flex justify-content-between">
                            <div class="font-weight-normal bd-highlight mr-5">{{$transaction->created_at->format("D, F-Y")}}
                            <span style="color: white;" class="badge badge-pill badge-primary">{{$transaction->created_at->format("H:m:s")}}</span>
                            </div>
                            <div class="font-weight-bolder bd-highlight ml-5">Rp {{number_format($transaction->total,0,",",".")}},-</div>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-sm-12">
                        <div class="row row-cols-3 justify-content-md-center">
                            @foreach ($transaction->shoes as $transactionDetail)
                            <div class="col mb-4">
                                <img src="/storage/{{ $transactionDetail->image }}" style="object-fit: cover" width="200px" height="200px" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @empty
                    <div class="d-flex flex-column align-items-center">
                        <div class="alert alert-info " style="width: 30%">
                            You Haven't made any transaction
                        </div>
                        <div>
                            <a class="btn btn-primary" href="/" role="button">Let's Go Shopping!</a>
                        </div>
                    </div>
                @endforelse
            </div>
          </div>
    </div>
</div>

@endsection

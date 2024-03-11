@extends('users.layout.layout')
@section('contents')

<h1>Order Details</h1>
<div class="container pb-5">
    <div class="row">
        @if ($product)
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="{{ asset('storage/images/' . $product->product_image) }}" alt="Product Image" id="product-detail">
                </div>
            </div>
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <p class="h3 py-2">{{ $product->name }}</p>
                        <p class="h3 py-2">Rs{{ number_format($product->saling_price, 2) }}</p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{ $product->brand }}</strong></p>
                            </li>
                        </ul>

                        <h6>Description:</h6>
                        <p>{{ $product->description }}</p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Available Color :</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{ $product->color}}</strong></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-12 mt-5">
                <p>No product found for this order.</p>
            </div>
        @endif
    </div>
</div>

@endsection

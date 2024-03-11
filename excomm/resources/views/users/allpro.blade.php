@extends('users.layout.layout')
@section('contents')

    <div class="row">
        @foreach ($products as $product)

        <div class="col-md-2">
            <a href="{{ route('users.single', ['id' => $product->id]) }}">
                <div class="card mb-4 product-wap rounded-0">
                    <div class="card rounded-0">
                        <img class="card-img rounded-0 img-fluid" src="storage/images/{{$product->product_image}}">
                        <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- 2 -->

                        <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                            <li>{{ $product->name }}</li>
                            <li class="pt-2">
                                <!-- 3 -->
                            </li>
                        </ul>
                        <p>Rs{{ number_format($product->saling_price, 2) }}</p>
                    </div>
                </div>
                </a>
        </div>
        @endforeach
    </div>

@endsection
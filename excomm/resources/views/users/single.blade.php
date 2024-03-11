@extends('users.layout.layout')
@section('contents')
<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
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

                        <form action="{{ route('add-cart') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Quantity Adjustment Buttons -->
                                <div class="col">
                                    <button type="button" onclick="updateQuantity('{{$product->id}}', 'decrement')" class="btn btn-secondary btn-sm">-</button>
                                    <span id="quantity{{$product->id}}">1</span>
                                    <button type="button" onclick="updateQuantity('{{$product->id}}', 'increment')" class="btn btn-secondary btn-sm">+</button>
                                </div>
                            </div>

                            <div class="row pb-3">
                                <input type="hidden" value="{{$product->id}}" name="product_id">
                                <input type="hidden" value="1" name="quantity" id="product-quantity{{$product->id}}">
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit" value="addtocart">Add To Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // JavaScript function to update quantity
    function updateQuantity(productId, action) {
        var quantityElement = document.getElementById('quantity' + productId);
        var quantityInput = document.getElementById('product-quantity' + productId);

        // Get the current quantity
        var currentQuantity = parseInt(quantityElement.textContent);

        // Update the quantity based on the action
        if (action === 'increment') {
            currentQuantity++;
        } else if (action === 'decrement' && currentQuantity > 1) {
            currentQuantity--;
        }

        // Update the HTML and the hidden input field
        quantityElement.textContent = currentQuantity;
        quantityInput.value = currentQuantity;
    }
</script>

@endsection

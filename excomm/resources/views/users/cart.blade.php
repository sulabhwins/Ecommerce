@extends('users.layout.layout')
@section('contents')
<div class="container mt-5">
    

    <h2>Your Cart</h2>
    @if(count($cart) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $cartProduct)
            <tr>
                <td>{{ $cartProduct->product->name }}</td>
                <td>Rs{{ number_format($cartProduct->product->saling_price, 2) }}</td>
                <td>
                    <button onclick="updateQuantity('{{$cartProduct->id}}', 'decrement')">-</button>
                    <span id="quantity{{$cartProduct->id}}">{{$cartProduct->quantity}}</span>
                    <button onclick="updateQuantity('{{$cartProduct->id}}', 'increment')">+</button>
                </td>
                <td id="subtotal{{$cartProduct->id}}">Rs{{ number_format($cartProduct->product->saling_price * $cartProduct->quantity, 2) }}</td>
                <td>
                    <form action="{{ route('delete-cart', ['id' => $cartProduct->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Why you add this item if you remove')">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <h4>Total Amount</h4>
        <p id="totalAmount">Rs{{ number_format($totalAmount, 2) }}</p>
        {{Session::put('totalAmount', $totalAmount)}}
    </div>
    <button onclick="buyNow()" class="btn btn-primary">Buy Now</button>

    @else
    <p>Your cart is empty.</p>
   
    @endif
  
    
</div>
<script>
    function updateQuantity(productId, action) {
        var quantityElement = document.getElementById('quantity' + productId);
        var currentQuantity = parseInt(quantityElement.innerHTML);

        if (action === 'increment') {
            currentQuantity += 1;
        } else if (action === 'decrement' && currentQuantity > 1) {
            currentQuantity -= 1;
        }

        quantityElement.innerHTML = currentQuantity;
        updateCartOnServer(productId, currentQuantity);
        updateTotalAmount(); // Update total amount after changing quantity
    }

    function updateCartOnServer(productId, newQuantity) {
        fetch('update-cart', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQuantity
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data)
                alert(data.message)
                window.location.reload();
            })
            .catch(error => {
                console.error('Error updating cart:', error);
            });

    }

    function updateTotalAmount() {
        // Calculate and update the total amount
        var totalAmount = 0;

        // Iterate through each row in the table
        var tableRows = document.querySelectorAll('table tbody tr');
        tableRows.forEach(function(row) {
            var quantity = parseInt(row.querySelector('[id^="quantity"]').innerText);
            var price = parseFloat(row.querySelector('[id^="subtotal"]').innerText.replace('Rs', '').replace(',', ''));
            totalAmount = quantity * price;
        });

        // Update the total amount on the page
        document.getElementById('totalAmount').innerText = 'Rs' + totalAmount.toFixed(2);
    }

    function buyNow() {
        // Redirect to the checkout page
        window.location.href = '{{ route("stripe") }}';
    }
</script>
@endsection
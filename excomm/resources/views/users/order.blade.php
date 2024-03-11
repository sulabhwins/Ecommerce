@extends('users.layout.layout')
@section('contents')

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quintity</th>
                <th>Total Amount</th>
                <th>Date of Order</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $orders as $order)
                <tr>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{$order->price*$order->quantity}}</td>
                    <td>{{date("d-m-Y", strtotime($order ['created_at']))}}</td>
                    <td><a href="{{ route('order.detail', ['id' => $order->id]) }}" class="btn btn-primary">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
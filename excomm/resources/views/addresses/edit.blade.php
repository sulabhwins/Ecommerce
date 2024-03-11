@extends('users.layout.layout')
@section('contents')

    <h2>Edit Address</h2>

    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="street_address">Street Address:</label>
            <input type="text" name="street_address" class="form-control" value="{{ $address->street_address }}" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" name="city" class="form-control" value="{{ $address->city }}" required>
        </div>

        <div class="form-group">
            <label for="state">State:</label>
            <input type="text" name="state" class="form-control" value="{{ $address->state }}" required>
        </div>

        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" name="postal_code" class="form-control" value="{{ $address->postal_code }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Address</button>
    </form>

    <a href="{{ route('addresses.index') }}">Back to Addresses</a>
@endsection



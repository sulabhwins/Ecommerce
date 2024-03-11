@extends('users.layout.layout')
@section('contents')
<h1>Create Address</h1>

<form action="{{ route('addresses.store') }}" method="POST">
    @csrf
    <div class="form-group hidden">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" class="form-control" value="{{ auth()->id() }}" readonly>
    </div>

    <div class="form-group">
        <label for="street_address">Street Address:</label>
        <input type="text" name="street_address" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" name="city" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="state">State:</label>
        <input type="text" name="state" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="postal_code">Postal Code:</label>
        <input type="text" name="postal_code" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Save Address</button>
</form>
@endsection
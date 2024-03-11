@extends('users.layout.layout')
@section('contents')
    <h1>Addresses</h1>

    <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Address</a>

    <table class="table">
        <thead>
            <tr>
                <th>Street Address</th>
                <th>City</th>
                <th>State</th>
                <th>Postal Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($addresses as $address)
                <tr>
                    <td>{{ $address->street_address }}</td>
                    <td>{{ $address->city }}</td>
                    <td>{{ $address->state }}</td>
                    <td>{{ $address->postal_code }}</td>
                    <td>
                    <a href="{{ route('addresses.edit', $address->id) }}">Edit</a>
                    <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this address?')">Remove</button>
                    </form>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
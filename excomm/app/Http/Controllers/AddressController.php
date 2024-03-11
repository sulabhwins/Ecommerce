<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        // Validate the request data as needed
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
        ]);

        // Create a new address
        Address::create($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address created successfully.');
    }
    public function editAddress($id)
{
    $address = Address::findOrFail($id);
    return view('addresses.edit', compact('address'));
}

public function updateAddress(Request $request, $id)
{
    $address = Address::findOrFail($id);
    $address->update($request->all());
    return redirect()->route('addresses.index')->with('success', 'Address updated successfully.');
}

public function destroyAddress($id)
{
    $address = Address::findOrFail($id);
    $address->delete();
    return redirect()->route('addresses.index')->with('success', 'Address removed successfully.');
}

}

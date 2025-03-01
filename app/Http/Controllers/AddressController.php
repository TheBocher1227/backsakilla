<?php
namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = Address::with(['city'])->paginate($request->input('per_page', 10));
        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:50',
            'address2' => 'nullable|string|max:50',
            'district' => 'required|string|max:20',
            'city_id' => 'required|exists:cities,id',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $address = Address::create($request->all());
        return response()->json($address, 201);
    }

    public function show(Address $address)
    {
        return response()->json($address->load(['city']));
    }

    public function update(Request $request, Address $address)
    {
        $request->validate([
            'address' => 'string|max:50',
            'address2' => 'nullable|string|max:50',
            'district' => 'string|max:20',
            'city_id' => 'exists:cities,id',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'string|max:20',
        ]);

        $address->update($request->all());
        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(null, 204);
    }
}

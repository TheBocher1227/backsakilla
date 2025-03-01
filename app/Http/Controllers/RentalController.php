<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $rentals = Rental::with(['customer', 'inventory', 'staff'])->paginate($request->input('per_page', 10));
        return response()->json($rentals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rental_date' => 'required|date',
            'inventory_id' => 'required|exists:inventory,id',
            'customer_id' => 'required|exists:customers,id',
            'return_date' => 'nullable|date',
            'staff_id' => 'required|exists:staff,id',
        ]);

        $rental = Rental::create($request->all());
        return response()->json($rental, 201);
    }

    public function show(Rental $rental)
    {
        return response()->json($rental->load(['customer', 'inventory', 'staff']));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'rental_date' => 'date',
            'inventory_id' => 'exists:inventory,id',
            'customer_id' => 'exists:customers,id',
            'return_date' => 'nullable|date',
            'staff_id' => 'exists:staff,id',
        ]);

        $rental->update($request->all());
        return response()->json($rental);
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return response()->json(null, 204);
    }
}

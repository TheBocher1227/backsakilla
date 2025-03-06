<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $rentals = Rental::with(['customer', 'staff'])->get();
    
        $rentals = $rentals->map(function ($rental) {
            return [
                'rental_id' => $rental->rental_id,
                'rental_date' => $rental->rental_date,
                'inventory_id' => $rental->inventory_id,
                'customer_id' => $rental->customer_id,
                'return_date' => $rental->return_date,
                'staff_id' => $rental->staff_id,
                'last_update' => $rental->last_update,
                'customer_name' => optional($rental->customer)->first_name . ' ' . optional($rental->customer)->last_name,
                'staff_name' => optional($rental->staff)->first_name . ' ' . optional($rental->staff)->last_name,
            ];
        });
    
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

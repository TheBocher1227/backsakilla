<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RentalController extends Controller
{
    public function __construct()
    {
        Route::bind('rental', function ($value) {
            return Rental::where('rental_id', $value)->firstOrFail();
        });
    }

    public function index(Request $request)
    {
        $rentals = Rental::with(['customer', 'staff', 'inventory'])->get();

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
                'film_title' => optional($rental->inventory)->film->title ?? null,
            ];
        });

        return response()->json($rentals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rental_date' => 'required|date',
            'inventory_id' => 'required|exists:inventory,inventory_id',
            'customer_id' => 'required|exists:customer,customer_id',
            'return_date' => 'nullable|date',
            'staff_id' => 'required|exists:staff,staff_id',
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
            'inventory_id' => 'exists:inventory,inventory_id',
            'customer_id' => 'exists:customer,customer_id',
            'return_date' => 'nullable|date',
            'staff_id' => 'exists:staff,staff_id',
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

<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventory = Inventory::with(['film', 'store'])->get();
        return response()->json($inventory);
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id' => 'required|exists:films,id',
            'store_id' => 'required|exists:stores,id',
        ]);

        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    public function show(Inventory $inventory)
    {
        return response()->json($inventory->load(['film', 'store']));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'film_id' => 'exists:films,id',
            'store_id' => 'exists:stores,id',
        ]);

        $inventory->update($request->all());
        return response()->json($inventory);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(null, 204);
    }
}

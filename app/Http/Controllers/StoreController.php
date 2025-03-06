<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::with(['manager', 'address'])->get();
        return response()->json($stores);
    }

    public function store(Request $request)
    {
        $request->validate([
            'manager_staff_id' => 'required|exists:staff,id',
            'address_id' => 'required|exists:addresses,id',
        ]);

        $store = Store::create($request->all());
        return response()->json($store, 201);
    }

    public function show(Store $store)
    {
        return response()->json($store->load(['manager', 'address']));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'manager_staff_id' => 'exists:staff,id',
            'address_id' => 'exists:addresses,id',
        ]);

        $store->update($request->all());
        return response()->json($store);
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return response()->json(null, 204);
    }
}


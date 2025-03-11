<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class StoreController extends Controller
{
    public function __construct()
    {
        Route::bind('store', function ($value) {
            return Store::where('store_id', $value)->firstOrFail();
        });
    }

    public function index(Request $request)
    {
        $stores = Store::with(['manager', 'address.city'])->get();
        $stores = $stores->map(function ($store) {
            return [
                'store_id' => $store->store_id,
                'manager_staff_id' => $store->manager_staff_id,
                'address_id' => $store->address_id,
                'last_update' => $store->last_update,
                'manager' => $store->manager ? [
                    'staff_id' => $store->manager->staff_id,
                    'first_name' => $store->manager->first_name,
                    'last_name' => $store->manager->last_name,
                    'email' => $store->manager->email,
                    'active' => $store->manager->active,
                ] : null,
                'address' => $store->address ?
                    $store->address->address . ', ' . optional($store->address->city)->city : null,
            ];
        });
        return response()->json($stores);
    }

    public function store(Request $request)
    {
        $request->validate([
            'manager_staff_id' => 'required|exists:staff,staff_id',
            'address_id' => 'required|exists:address,address_id',
        ]);

        $store = Store::create($request->all());
        return response()->json($store, 201);
    }

    public function show(Store $store)
    {
        $store->load(['manager', 'address.city']);
        return response()->json([
            'store_id' => $store->store_id,
            'manager_staff_id' => $store->manager_staff_id,
            'address_id' => $store->address_id,
            'last_update' => $store->last_update,
            'manager' => $store->manager ? [
                'staff_id' => $store->manager->staff_id,
                'first_name' => $store->manager->first_name,
                'last_name' => $store->manager->last_name,
                'email' => $store->manager->email,
                'active' => $store->manager->active,
            ] : null,
            'address' => $store->address ?
                $store->address->address . ', ' . optional($store->address->city)->city : null,
        ]);
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'manager_staff_id' => 'exists:staff,staff_id',
            'address_id' => 'exists:address,address_id',
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


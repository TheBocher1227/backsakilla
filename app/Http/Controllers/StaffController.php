<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $staff = Staff::with(['store', 'address'])->get();
        return response()->json($staff);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'address_id' => 'required|exists:addresses,id',
            'email' => 'required|email|unique:staff',
            'store_id' => 'required|exists:stores,id',
            'active' => 'boolean',
            'username' => 'required|string|max:16|unique:staff',
            'password' => 'required|string|min:8',
        ]);

        $staff = Staff::create($request->all());
        return response()->json($staff, 201);
    }

    public function show(Staff $staff)
    {
        return response()->json($staff->load(['store', 'address']));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name' => 'string|max:45',
            'last_name' => 'string|max:45',
            'address_id' => 'exists:addresses,id',
            'email' => 'email|unique:staff,email,' . $staff->id,
            'store_id' => 'exists:stores,id',
            'active' => 'boolean',
            'username' => 'string|max:16|unique:staff,username,' . $staff->id,
            'password' => 'string|min:8',
        ]);

        $staff->update($request->all());
        return response()->json($staff);
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return response()->json(null, 204);
    }
}

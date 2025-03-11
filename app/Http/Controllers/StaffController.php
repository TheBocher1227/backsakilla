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
            'address_id' => 'required|exists:address,address_id',
            'email' => 'required|email|unique:staff',
            'store_id' => 'required|exists:store,store_id',
            'username' => 'required|string|max:16|unique:staff',
            'password' => 'required|string|min:8',
        ]);

        $data = $request->all();
        $data['active'] = true;
        $data['last_update'] = now();

        $staff = Staff::create($data);
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
            'address_id' => 'exists:address,address_id',
            'email' => 'email|unique:staff,email,' . $staff->staff_id . ',staff_id',
            'store_id' => 'exists:store,store_id',
            'username' => 'string|max:16|unique:staff,username,' . $staff->staff_id . ',staff_id',
            'password' => 'string|min:8',
        ]);

        $data = $request->all();
        $data['last_update'] = now();

        $staff->update($data);
        return response()->json($staff);
    }

    public function destroy(Staff $staff)
    {
        $staff->update([
            'active' => false,
            'last_update' => now()
        ]);
        return response()->json(null, 204);
    }
}

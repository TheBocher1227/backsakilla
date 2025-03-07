<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  

   
   

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'required|email|unique:customers',
            'address_id' => 'required|exists:addresses,id',
            'active' => 'boolean',
        ]);

        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer->load(['store', 'address']));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'store_id' => 'exists:stores,id',
            'first_name' => 'string|max:45',
            'last_name' => 'string|max:45',
            'email' => 'email|unique:customers,email,' . $customer->id,
            'address_id' => 'exists:addresses,id',
            'active' => 'boolean',
        ]);

        $customer->update($request->all());
        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}

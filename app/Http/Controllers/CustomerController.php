<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with(['store', 'address'])->get();
        $customers = $customers->map(function ($customer){
            return[
            'customer_id' =>$customer->customer_id,
            'store_id'=>$customer->store_id
			"first_name": "MARY",
			"last_name": "SMITH",
			"email": "MARY.SMITH@sakilacustomer.org",
			"address_id": 5,
			"activebool": true,
			"create_date": "2006-02-14",
			"last_update": "2006-02-15 04:57:20",
			"active": 1,
			"store"=> optional($customer->store)->first_name . ' ' . optional($rental->customer)->last_name,
			"address": null

            ];
        });
        return response()->json($customers);
    }

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

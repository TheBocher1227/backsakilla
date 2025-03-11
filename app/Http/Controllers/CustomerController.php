<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CustomerController extends Controller
{
    public function __construct()
    {
        Route::bind('customer', function ($value) {
            return Customer::where('customer_id', $value)->firstOrFail();
        });
    }

    public function index(Request $request)
    {
        $customers = Customer::with(['store', 'address'])->get();
        $customers = $customers->map(function ($customer){
            return[
                'customer_id' => $customer->customer_id,
                'store_id' => $customer->store_id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'address_id' => $customer->address_id,
                'activebool' => $customer->activebool,
                'create_date' => $customer->create_date,
                'last_update' => $customer->last_update,
                'active' => $customer->active,
                'store' => optional($customer->store)->name,
                'address' => optional($customer->address)->address
            ];
        });
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:store,store_id',
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'required|email|unique:customer,email',
            'address_id' => 'required|exists:address,address_id',
            'active' => 'boolean',
        ]);

        $data = $request->all();
        $data['active'] = true;
        $data['create_date'] = now();
        $customer = Customer::create($data);
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer->load(['store', 'address']));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'store_id' => 'exists:store,store_id',
            'first_name' => 'string|max:45',
            'last_name' => 'string|max:45',
            'email' => 'email|unique:customer,email,' . $customer->customer_id . ',customer_id',
            'address_id' => 'exists:address,address_id',
            'active' => 'boolean',
        ]);

        $customer->update($request->all());
        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->update(['active' => false]);
        return response()->json(['message' => 'Cliente desactivado correctamente'], 200);
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['customer', 'staff', 'rental'])->paginate($request->input('per_page', 10));
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'staff_id' => 'required|exists:staff,id',
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }

    public function show(Payment $payment)
    {
        return response()->json($payment->load(['customer', 'staff', 'rental']));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'customer_id' => 'exists:customers,id',
            'staff_id' => 'exists:staff,id',
            'rental_id' => 'exists:rentals,id',
            'amount' => 'numeric',
            'payment_date' => 'date',
        ]);

        $payment->update($request->all());
        return response()->json($payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(null, 204);
    }
}

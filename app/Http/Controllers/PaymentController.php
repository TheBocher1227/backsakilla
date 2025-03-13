<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        Route::bind('payment', function ($value) {
            return Payment::where('payment_id', $value)->firstOrFail();
        });
    }

    public function index(Request $request)
    {
        $payments = Payment::with(['customer', 'staff', 'rental'])->get();
        $payments = $payments->map(function ($payment){
            return[
                "payment_id" => $payment->payment_id,
                "customer_id" => $payment->customer_id,
                "staff_id" => $payment->staff_id,
                "rental_id" => $payment->rental_id,
                "amount" => $payment->amount,
                "payment_date" => $payment->payment_date,
                "customer" => optional($payment->customer)->first_name . ' ' . optional($payment->customer)->last_name,
                "staff" => optional($payment->staff)->first_name . ' ' . optional($payment->staff)->last_name,
                "rental_info" => optional($payment->rental)->rental_date ?? null
            ];
        });
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customer,customer_id',
            'staff_id' => 'required|exists:staff,staff_id',
            'rental_id' => 'required|exists:rental,rental_id',
            'amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            $paymentId = DB::select("SELECT nextval('payment_payment_id_seq')")[0]->nextval;
            DB::insert(
                'INSERT INTO payment (payment_id, customer_id, staff_id, rental_id, amount, payment_date) VALUES (?, ?, ?, ?, ?, ?)',
                [$paymentId, $request->customer_id, $request->staff_id, $request->rental_id, $request->amount, now()]
            );
            DB::commit();
            $payment = Payment::with(['customer', 'staff', 'rental'])->find($paymentId);
            return response()->json([
                "payment_id" => $payment->payment_id,
                "customer_id" => $payment->customer_id,
                "staff_id" => $payment->staff_id,
                "rental_id" => $payment->rental_id,
                "amount" => $payment->amount,
                "payment_date" => $payment->payment_date,
                "customer" => optional($payment->customer)->first_name . ' ' . optional($payment->customer)->last_name,
                "staff" => optional($payment->staff)->first_name . ' ' . optional($payment->staff)->last_name,
                "rental_info" => optional($payment->rental)->rental_date ?? null
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear el pago: ' . $e->getMessage()], 500);
        }
    }

    public function show(Payment $payment)
    {
        $payment->load(['customer', 'staff', 'rental']);
        return response()->json([
            "payment_id" => $payment->payment_id,
            "customer_id" => $payment->customer_id,
            "staff_id" => $payment->staff_id,
            "rental_id" => $payment->rental_id,
            "amount" => $payment->amount,
            "payment_date" => $payment->payment_date,
            "customer" => optional($payment->customer)->first_name . ' ' . optional($payment->customer)->last_name,
            "staff" => optional($payment->staff)->first_name . ' ' . optional($payment->staff)->last_name,
            "rental_info" => optional($payment->rental)->rental_date ?? null
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'customer_id' => 'exists:customer,customer_id',
            'staff_id' => 'exists:staff,staff_id',
            'rental_id' => 'exists:rental,rental_id',
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

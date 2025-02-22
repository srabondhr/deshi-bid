<?php
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;

class PaymentController extends Controller {
    public function processPayment(Request $request) {
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid('txn_'),
            'status' => 'pending'
        ]);

        // Simulate Payment Gateway (Example)
        if ($request->payment_method === 'paypal') {
            $payment->status = 'completed';
            $payment->save();

            Transaction::create([
                'user_id' => auth()->id(),
                'payment_id' => $payment->id,
                'amount' => $request->amount,
                'payment_method' => 'paypal',
                'status' => 'success'
            ]);

            return response()->json(['message' => 'Payment Successful']);
        }

        return response()->json(['message' => 'Payment Failed'], 400);
    }
}

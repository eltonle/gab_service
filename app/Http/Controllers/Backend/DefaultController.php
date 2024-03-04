<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function getCategory(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $allCategory = Product::with(['category'])->select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->get();
        return response()->json($allCategory);
    } //END METHOD

    public function getProduct(Request $request)
    {
        $category_id = $request->category_id;
        $allProduct = Product::where('category_id', $category_id)->get();
        return response()->json($allProduct);
    } // END METHOD
    public function getStock(Request $request)
    {
        $product_id = $request->product_id;
        $stock = Product::where('id', $product_id)->first()->quantity;
        return response()->json($stock);
    } // END METHOD

    //    OBTENIR LES DETAILS DE PAYMENTS
    public function getPayment(Request $request)
    {

        $invoiceId = $request->input('invoice_id');
        $fullDataPay = Payment::where('invoice_id', $invoiceId)->first();

        $payments = PaymentDetail::where('invoice_id', $invoiceId)->get();
        // $payments = PaymentDetail::all();

        return response()->json([
            'payments' => $payments,
            'invoiceId' => $invoiceId,
            'fullDataPay' => $fullDataPay
        ]);
    } // END METHOD

    // METTRE A JOUR LES PAIEMENTS
    public function updatePayment(Request $request)
    {

        $invoiceId = $request->input('invoice_id');
        $paidAmount = $request->input('paid_amount');
        $invoiceUpdate = Invoice::find($invoiceId);
        $payment = Payment::where('invoice_id', $invoiceId)->firstOrFail();
        $existPaidAmount = $payment->paid_amount;
        $existDueAmount = $payment->due_amount;
        $payment->paid_amount =  $paidAmount + $existPaidAmount;
        $payment->due_amount = $existDueAmount - $paidAmount;
        if ($existDueAmount == $paidAmount) {
            $payment->paid_status = 'full_paid';
            $invoiceUpdate->livraison = '0';
        }
        DB::transaction(
            function () use ($request, $payment) {
                $invoiceId = $request->input('invoice_id');
                $paidAmount = $request->input('paid_amount');
                if ($payment->save()) {
                    $newPaymentDetails = new PaymentDetail();
                    $newPaymentDetails->invoice_id = $invoiceId;
                    $newPaymentDetails->current_paid_amount = $paidAmount;
                    $newPaymentDetails->date = now();
                    $newPaymentDetails->save();
                }
            }
        );
        if ($payment->paid_status = 'full_paid') {
            # code...
            $invoiceUpdate->save();
        }

        // Effectuez les opérations nécessaires pour mettre à jour les champs dans la base de données

        return response()->json(['message' => 'Paiement effectue avec succès .']);
    } // END METHOD

}

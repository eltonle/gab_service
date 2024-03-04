<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $allData = Invoice::orderBy('date', 'desc')->where('status', '1')->orderBy('id', 'desc')->get();
        return view('frontend.invoice.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        $data['categories'] = Category::all();
        $invoice_data = Invoice::orderBy('id', 'desc')->first();
        if ($invoice_data == null) {
            $firstReg = '0';
            $data['invoice_no'] = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $data['invoice_no'] = $invoice_data + 1;
        }
        $data['customers'] = Customer::all();
        $data['date'] = date('Y-m-d');
        return view('frontend.invoice.create', $data);
    } //END METHOD


    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->category_id == null) {

            $notification = array(
                'message' => ' Sorry! you do not select any item',
                'alert-type' => 'error'
            );

            return  redirect()->back()->with($notification);
        } else {
            if ($request->paid_amount > $request->estimated_amount) {
                $notification = array(
                    'message' => ' Sorry! montant tres elevé a au montant total',
                    'alert-type' => 'error'
                );
                return  redirect()->back()->with($notification);
            } else {
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;
                DB::transaction(function () use ($request, $invoice) {
                    if ($invoice->save()) {
                        $count_category = count($request->category_id);
                        for ($i = 0; $i < $count_category; $i++) {
                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = $request->date;
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '1';
                            $invoice_details->save();
                        }
                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->email = $request->email;
                            $customer->address = $request->address;
                            $customer->phone = $request->phone;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }
                        $payment = new Payment();
                        $payment_details = new PaymentDetail();
                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;
                        if ($request->paid_status == 'full_paid') {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } elseif ($request->paid_status == 'full_due') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        } elseif ($request->paid_status == 'partial_paid') {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }
                        $payment->save();
                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->date));
                        $payment_details->save();
                    }
                });
                $invoice->save();
            }
        }
        $notification = array(
            'message' => ' invoice save succeffully',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending')->with($notification);
    } // END METHOD

    public function pendingList()
    {
        $allData = Invoice::orderBy('date', 'desc')->where('status', '0')->orderBy('id', 'desc')->get();
        return view('frontend.invoice.pending', compact('allData'));
    } //END METHOD

    public function approveList($id)
    {
        $invoice = Invoice::with(['invoice_details'])->find($id);

        return view('frontend.invoice.approve', compact('invoice'));
    } //END METHOD

    public function approveStore(Request $request, $id)
    {
        foreach ($request->selling_qty as $key => $val) {
            $invoice_details = InvoiceDetail::where('id', $key)->first();
            $product_name = Product::where('id', $invoice_details->product_id)->first();
            if ($product_name->quantity < $request->selling_qty[$key]) {
                $notification = array(
                    'message' => 'Sorry!, valeur trop eleveé',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }

        $invoice = Invoice::find($id);
        $invoice->approved_by = Auth::user()->id;
        $invoice->status = '1';
        DB::transaction(function () use ($request, $invoice, $id) {
            foreach ($request->selling_qty as $key => $val) {
                $invoice_details = InvoiceDetail::where('id', $key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
                $product_name = Product::where('id', $invoice_details->product_id)->first();
                $product_name->quantity = ((float)$product_name->quantity) - ((float)$request->selling_qty[$key]);
                $product_name->save();
            }
            $invoice->save();
        });

        $notification = array(
            'message' => ' Facture approuveé avec succes',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending')->with($notification);
    } //END METHOD

    public function printInvoice($id)
    {
        $data['invoice'] = Invoice::with(['invoice_details'])->find($id);
        $pdf = PDF::loadView('frontend.pdf.invoice', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD


    public function delete($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();
        $notification = array(
            'message' => ' invoice delete succeffully',
            'alert-type' => 'error'
        );
        return redirect()->route('invoice.pending')->with($notification);
    } //END METHOD

    public function dailyReport()
    {
        return view('frontend.invoice.daily');
    } //END METHOD

    public function dailyReportPdf(Request $request)
    {

        $data['date'] = date('d-M-Y');
        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));
        $data['allData'] = Invoice::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();
        $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
        $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
        $pdf = PDF::loadView('frontend.pdf.daily', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD
}

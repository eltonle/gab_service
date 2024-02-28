<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CustomerController extends Controller
{
    public function index()
    {
        $allData = Customer::all();
        return view('frontend.customers.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.customers.create');
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        $notification = array(
            'message' => ' customer Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customers.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = Customer::findOrFail($id);
        return view('frontend.customers.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $notification = array(
            'message' => ' Customer Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customers.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = Customer::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' Customer delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('customers.index')->with($notification);
    } //END METHOD

    // DETTE OU CREDIT
    public function creditCustomer()
    {
        $data = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();

        return view('frontend.customers.credit', compact('data'));
    } // END METHOD

    public function creditcustomerpdf()
    {
        $data['data'] = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        $pdf = PDF::loadView('frontend.pdf.customer-credit-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } // END METHOD

    public function invoiceDetailsPdf($id)
    {
        $data['payment'] = Payment::where('invoice_id', $id)->first();
        $pdf = PDF::loadView('frontend.pdf.invoice-details-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } // END METHOD

    // PAYMENT DETTE
    public function paidCustomer()
    {
        $data = Payment::where('paid_status', '!=', 'full_due')->get();

        return view('frontend.customers.paid', compact('data'));
    } // END METHOD

    public function paidCustomerpdf()
    {
        $data['data'] = Payment::where('paid_status', '!=', 'full_due')->get();
        $pdf = PDF::loadView('frontend.pdf.customer-paid-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } // END METHOD

    // REPORT CUSTOMER WISE

    public function wiseReport()
    {
        $customers = Customer::all();
        return view('frontend.customers.wise-report', compact('customers'));
    } // END METHOD

    // credit customer

    public function wiseCredit(Request $request)
    {
        $data['data'] = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        $pdf = PDF::loadView('frontend.pdf.customer-wise-credit-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    // paid customer

    public function wisePaid(Request $request)
    {
        $data['data'] = Payment::where('customer_id', $request->customer_id)->where('paid_status', '!=', 'full_due')->get();
        $pdf = PDF::loadView('frontend.pdf.customer-wise-paid-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    //Payment
    public function payment()
    {
        if ($request->new_paid_amount < $request->paid_amount) {
            Toastr::error('Soory! Somme plus elevée');
            return redirect()->back();
          } else {
            $payment = Payment::where('invoice_id', $invoice_id)->first();
            $payment_details = new PaymentDetail();
            $payment->paid_status = $request->paid_status;
            if ($request->paid_status == 'full_paid') {
              $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->new_paid_amount;
              $payment->due_amount = '0';
              $payment_details->current_paid_amount = $request->new_paid_amount;
            } elseif ($request->paid_status == 'partial_paid') {
              $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->paid_amount;
              $payment->due_amount = Payment::where('invoice_id', $invoice_id)->first()['due_amount'] - $request->paid_amount;
              $payment_details->current_paid_amount = $request->paid_amount;
            }
            $payment->save();
            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->save();
            Toastr::success('Facture mise a jour avec succès', 'success');
            return redirect()->route('customers.credit');
    }
}

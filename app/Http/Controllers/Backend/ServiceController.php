<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServicePayment;
use App\Models\ServicePaymentDetail;
use App\Models\Task;
use App\Models\Technical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ServiceController extends Controller
{
    public function index()
    {
        $allData = Service::orderBy('date', 'desc')->where('status', '1')->orderBy('id', 'desc')->get();
        // dd($allData);
        return view('frontend.services.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        $data['techniciens'] = Technical::all();
        $data['taches'] = Task::all();
        $invoice_data = Service::orderBy('id', 'desc')->first();
        if ($invoice_data == null) {
            $firstReg = '0';
            $data['invoice_no'] = $firstReg + 1;
        } else {
            $invoice_data = Service::orderBy('id', 'desc')->first()->invoice_no;
            $data['invoice_no'] = $invoice_data + 1;
        }
        $data['customers'] = Customer::all();
        $data['date'] = date('Y-m-d');
        return view('frontend.services.create', $data);
    } //END METHOD


    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->technical_id == null || $request->customer_id == null) {

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
                $invoice = new Service();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;
                DB::transaction(function () use ($request, $invoice) {
                    if ($invoice->save()) {
                        $count_technical = count($request->technical_id);
                        for ($i = 0; $i < $count_technical; $i++) {
                            $invoice_details = new ServiceDetail();
                            $invoice_details->date = $request->date;
                            $invoice_details->service_id = $invoice->id;
                            $invoice_details->technical_id = $request->technical_id[$i];
                            $invoice_details->task_id = $request->task_id[$i];
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
                        $payment = new ServicePayment();
                        $payment_details = new ServicePaymentDetail();
                        $payment->service_id = $invoice->id;
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
                        $payment_details->service_id = $invoice->id;
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
        return redirect()->route('service.pending')->with($notification);
    } // END METHOD

    public function pendingList()
    {
        $allData = Service::orderBy('date', 'desc')->where('status', '0')->orderBy('id', 'desc')->get();
        return view('frontend.services.pending', compact('allData'));
    } //END METHOD

    public function approveList($id)
    {
        $invoice = Service::with(['invoice_details'])->find($id);
        // dd($invoice);
        return view('frontend.services.approve', compact('invoice'));
    } //END METHOD

    public function approveStore(Request $request, $id)
    {
        foreach ($request->selling_qty as $key => $val) {
            $invoice_details = ServiceDetail::where('id', $key)->first();
            $task = Task::where('id', $invoice_details->task_id)->first();
            if (!$task || !$invoice_details) {
                $notification = array(
                    'message' => 'Sorry!, tache non existante',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }

        $invoice = Service::find($id);
        $invoice->approved_by = Auth::user()->id;
        $invoice->status = '1';
        DB::transaction(function () use ($request, $invoice, $id) {
            foreach ($request->selling_qty as $key => $val) {
                $invoice_details = ServiceDetail::where('id', $key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
            }
            $invoice->save();
        });

        $notification = array(
            'message' => ' Facture approuveé avec succes',
            'alert-type' => 'success'
        );
        return redirect()->route('service.index')->with($notification);
    } //END METHOD

    public function printInvoice($id)
    {
        $data['invoice'] = Service::with(['invoice_details'])->find($id);
        $pdf = PDF::loadView('frontend.pdf.service', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD


    public function delete($id)
    {
        $invoice = Service::find($id);
        $invoice->delete();
        ServiceDetail::where('invoice_id', $invoice->id)->delete();
        ServicePayment::where('invoice_id', $invoice->id)->delete();
        ServicePaymentDetail::where('invoice_id', $invoice->id)->delete();
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
        $data['allData'] = Service::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();
        $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
        $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
        $pdf = PDF::loadView('frontend.pdf.daily', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class PurchaseController extends Controller
{
    public function index()
    {
        $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('frontend.purchase.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        $data['suppliers'] = supplier::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        return view('frontend.purchase.create', $data);
    } //END METHOD

    public function store(Request $request)
    {
        if ($request->category_id == null) {
            $notification = array(
                'message' => ' Sorry! you do not delect any item',
                'alert-type' => 'error'
            );
            return  redirect()->back()->with($notification);
        } else {
            $count_category = count($request->category_id);
            // dd($count_category);
            for ($i = 0; $i < $count_category; $i++) {
                $purchase = new Purchase();
                $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];
                $purchase->product_id = $request->product_id[$i];
                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];
                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->save();
            }
        }
        $notification = array(
            'message' => ' Data save succeffully',
            'alert-type' => 'success'
        );
        return redirect()->route('purchase.index')->with($notification);
    } // END METHOD

    public function pendingList()
    {
        $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
        return view('frontend.purchase.pending', compact('allData'));
    } //END METHOD

    public function purchaseReport()
    {
        return  view('frontend.purchase.daily');
    } // END METHOD


    public function purchaseReportPdf(Request $request)
    {
        $data['date'] = date('d-M-Y');
        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));
        $data['allData'] = Purchase::whereBetween('date', [$sdate, $edate])->where('status', '1')->orderBy('category_id')->orderBy('product_id')->orderBy('supplier_id')->get();
        $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
        $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
        $pdf = PDF::loadView('frontend.pdf.daily_purchase', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } // END METHOD

    public function approveList($id)
    {
        $purchase = Purchase::find($id);
        $product = Product::where('id', $purchase->product_id)->first();
        $purchase_qty = ((float)($purchase->buying_qty)) + ((float)($product->quantity));
        $product->quantity = $purchase_qty;
        if ($product->save()) {
            DB::table('purchases')
                ->where('id', $id)
                ->update(['status' => 1]);
        }
        $notification = array(
            'message' => ' Data Approved succeffully',
            'alert-type' => 'success'
        );
        return redirect()->route('purchase.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        $notification = array(
            'message' => ' Data delete succeffully',
            'alert-type' => 'error'
        );
        return redirect()->route('purchase.index')->with($notification);
    } //END METHOD
}

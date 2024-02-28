<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\supplier;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class StockController extends Controller
{
    public function stockReport()
    {
        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('frontend.stock.index', compact('allData'));
    } //END METHOD

    public function stockReportPdf()
    {
        // dd('ok');
        $data['date'] = Carbon::now();
        $data['allData'] = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        $pdf = PDF::loadView('frontend.pdf.report_stock', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD

    public function supplierProductWise()
    {
        $data['suppliers'] = supplier::all();
        $data['categories'] = Category::all();
        return view('frontend.stock.supplier_prod', $data);
    } //END METHOD

    public function supplierWisePdf(Request $request)
    {

        $data['date'] = Carbon::now();
        $data['allData'] = Product::where('supplier_id', $request->supplier_id)->get();
        // dd($data);
        $pdf = PDF::loadView('frontend.pdf.report-supplier-stock-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD

    public function productWisePdf(Request $request)
    {

        $data['date'] = Carbon::now();
        $data['product'] = Product::where('category_id', $request->category_id)->where('id', $request->product_id)->first();
        $pdf = PDF::loadView('frontend.pdf.report_product_stock_pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    } //END METHOD
}

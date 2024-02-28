<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $allData = supplier::all();
        return view('frontend.suppliers.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.suppliers.create');
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required',
            'supplier_email' => 'required|email',
            'supplier_phone' => 'required',
            'supplier_address' => 'required',
        ]);

        Supplier::create($request->all());
        $notification = array(
            'message' => ' Supplier Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('suppliers.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = Supplier::findOrFail($id);
        return view('frontend.suppliers.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required',
            'supplier_email' => 'required|email',
            'supplier_phone' => 'required',
            'supplier_address' => 'required',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        $notification = array(
            'message' => ' Supplier Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('suppliers.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = supplier::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' Supplier delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('suppliers.index')->with($notification);
    } //END METHOD
}

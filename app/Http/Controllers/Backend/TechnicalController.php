<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Technical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicalController extends Controller
{
    public function index()
    {
        $allData = Technical::all();
        return view('frontend.technical.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.technical.create');
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $customer = new Technical();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        $notification = array(
            'message' => ' technical Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('technical.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = Technical::findOrFail($id);
        return view('frontend.technical.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $customer = Technical::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $notification = array(
            'message' => ' technical Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('technical.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = Technical::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' technical delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('technical.index')->with($notification);
    } //END METHOD
}

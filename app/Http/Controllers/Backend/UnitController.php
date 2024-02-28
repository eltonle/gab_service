<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        $allData = Unit::all();
        return view('frontend.units.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.units.create');
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $customer = new Unit();
        $customer->name = $request->name;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        $notification = array(
            'message' => ' Unit Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('units.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = Unit::findOrFail($id);
        return view('frontend.units.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer = Unit::findOrFail($id);
        $customer->name = $request->name;
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $notification = array(
            'message' => ' Unit Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('units.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = Unit::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' Unit delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('units.index')->with($notification);
    } //END METHOD
}

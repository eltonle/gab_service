<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $allData = Category::all();
        return view('frontend.category.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.category.create');
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $customer = new Category();
        $customer->name = $request->name;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        $notification = array(
            'message' => ' Category Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('categories.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = Category::findOrFail($id);
        return view('frontend.category.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer = Category::findOrFail($id);
        $customer->name = $request->name;
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $notification = array(
            'message' => ' Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('categories.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = Category::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' Category delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('categories.index')->with($notification);
    } //END METHOD
}

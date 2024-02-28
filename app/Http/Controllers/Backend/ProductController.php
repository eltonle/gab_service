<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $allData = Product::all();
        return view('frontend.product.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        $data['suppliers'] = supplier::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        return view('frontend.product.create', $data);
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'name' => 'required',
        ]);
        $product = new Product();
        $product->supplier_id = $request->supplier_id;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->name = $request->name;
        $product->quantity = '0';
        $product->created_by = Auth::user()->id;
        $product->save();

        $notification = array(
            'message' => ' Product Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('products.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $data['editData'] = Product::findOrFail($id);
        $data['suppliers'] = supplier::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        return view('frontend.product.edit', $data);
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'name' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->supplier_id = $request->supplier_id;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->name = $request->name;
        $product->updated_by = Auth::user()->id;
        $product->save();
        $notification = array(
            'message' => ' Product Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('products.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $notification = array(
            'message' => ' Product delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('products.index')->with($notification);
    } //END METHOD
}

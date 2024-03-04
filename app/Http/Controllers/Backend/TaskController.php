<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $allData = Task::all();
        return view('frontend.task.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.task.create');
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $customer = new Task();
        $customer->name = $request->name;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        $notification = array(
            'message' => ' Task Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('task.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = Task::findOrFail($id);
        return view('frontend.task.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer = Task::findOrFail($id);
        $customer->name = $request->name;
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $notification = array(
            'message' => ' task Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('task.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = Task::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' Task delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('task.index')->with($notification);
    } //END METHOD
}

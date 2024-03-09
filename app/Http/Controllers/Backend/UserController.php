<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $allData = User::all();
        return view('frontend.users.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        return view('frontend.users.create');
    } //END METHOD


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'username' => ['required', 'string', 'max:255'],
            'email' => 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class,
            'phone' => 'required',
            'address' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = new User();
        $customer->name = $request->name;
        $customer->username = $request->username;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->password = Hash::make($request->password);
        $customer->created_by = Auth::user()->id;
        $customer->save();

        $notification = array(
            'message' => ' Users Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);
    } //END METHOD

    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('frontend.users.edit', compact('item'));
    } //END METHOD

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'user_type' => 'required'
        ]);

        $customer = User::findOrFail($id);
        $customer->name = $request->name;
        $customer->username = $request->username;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->user_type = $request->user_type;
        $customer->updated_by = Auth::user()->id;
        $customer->save();
        $notification = array(
            'message' => ' User Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);
    } //END METHOD

    public function delete($id)
    {
        $supplier = User::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' User delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('users.index')->with($notification);
    } //END METHOD
}

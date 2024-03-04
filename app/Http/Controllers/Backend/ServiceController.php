<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Technical;
use App\Models\Technical_Task_Amount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $allData = Technical_Task_Amount::select('technical_id')->groupBy('technical_id')->get();
        return view('frontend.service.index', compact('allData'));
    } //END METHOD

    public function create()
    {
        $data['technicals'] = Technical::all();
        $data['tasks'] = Task::all();
        return view('frontend.service.create', $data);
    } //END METHOD


    public function store(Request $request)
    {
        $request->validate([
            'technical_id' => 'required',
            'task_id' => 'required',
            'amount' => 'required',
        ]);

        $countTask = count($request->task_id);
        if ($countTask != NULL) {
            for ($i = 0; $i < $countTask; $i++) {
                $service = new Technical_Task_Amount();
                $service->technical_id = $request->technical_id;
                $service->task_id = $request->task_id[$i];
                $service->amount = $request->amount[$i];
                $service->date = Carbon::now();
                $service->created_by = Auth::user()->id;
                $service->save();
            }
        }


        $notification = array(
            'message' => ' Service Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('service.index')->with($notification);
    } //END METHOD

    public function edit($technical_id)
    {
        $dateNow = date('Y-m-d');
        // dd($dateNow);
        $data['editData'] = Technical_Task_Amount::where('technical_id', $technical_id)->where('date', $dateNow)->orderBy('task_id', 'asc')->get();
        $data['technicals'] = Technical::all();
        $data['tasks'] = Task::all();
        return view('frontend.service.edit', $data);
    } //END METHOD

    public function update(Request $request, $technical_id)
    {
        $request->validate([
            'technical_id' => 'required',
            'task_id' => 'required',
            'amount' => 'required',
        ]);

        if ($request->task_id == NULL) {
            $notification = array(
                'message' => " Sorry, you don't selected any think",
                'alert-type' => 'error'
            );
            redirect()->back()->with($notification);
        } else {
            $dateNow = date('Y-m-d');
            Technical_Task_Amount::where('technical_id', $technical_id)->where('date', $dateNow)->delete();
            $countTask = count($request->task_id);
            if ($countTask != NULL) {
                for ($i = 0; $i < $countTask; $i++) {
                    $service = new Technical_Task_Amount();
                    $service->technical_id = $request->technical_id;
                    $service->task_id = $request->task_id[$i];
                    $service->amount = $request->amount[$i];
                    $service->date = Carbon::now();
                    $service->created_by = Auth::user()->id;
                    $service->save();
                }
            }
        }



        $notification = array(
            'message' => ' Service Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('service.index')->with($notification);
    } //END METHOD



    public function details($technical_id)
    {
        $data['allData'] = Technical_Task_Amount::where('technical_id', $technical_id)->orderBy('task_id', 'asc')->get();

        return view('frontend.service.details', $data);
    } //END METHOD

    public function delete($id)
    {
        $supplier = Technical_Task_Amount::findOrFail($id);
        $supplier->delete();
        $notification = array(
            'message' => ' Service delete Successfully',
            'alert-type' => 'error'
        );
        return redirect()->route('service.index')->with($notification);
    } //END METHOD
}

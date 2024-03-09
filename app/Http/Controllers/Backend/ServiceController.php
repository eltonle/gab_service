<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Technical;
use App\Models\Technical_Task_Amount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ServiceController extends Controller
{
    public function index()
    {
        $allData = Technical_Task_Amount::select('technical_id')->groupBy('technical_id')->orderBy('technical_id', 'asc')->get();
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
        // Obtenir la prochaine valeur de facture_id
        $maxFactureId = Technical_Task_Amount::max('facture_id');

        // Déterminer la valeur suivante
        $nextFactureId = ($maxFactureId !== null) ? $maxFactureId + 1 : 1;

        $countTask = count($request->task_id);
        if ($countTask != NULL) {
            for ($i = 0; $i < $countTask; $i++) {
                $service = new Technical_Task_Amount();
                $service->technical_id = $request->technical_id;
                $service->task_id = $request->task_id[$i];
                $service->amount = $request->amount[$i];
                $service->date = Carbon::now();
                $service->facture_id = $nextFactureId; // Utiliser la variable
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


    public function edit($facture_id)
    {
        $dateNow = date('Y-m-d');
        // dd($dateNow);
        $editData = Technical_Task_Amount::where('facture_id', $facture_id)->orderBy('task_id', 'asc')->get();
        $data['editData'] = Technical_Task_Amount::where('facture_id', $facture_id)->orderBy('task_id', 'asc')->get();
        // dd($data['editData'][0]);
        $data['technicals'] = Technical::all();
        $data['tasks'] = Task::all();
        // dd($data['editData']);
        if ($editData->isEmpty()) {
            $notification = array(
                'message' => ' Tache non Disponible ',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        return view('frontend.service.edit', $data);
    } //END METHOD

    public function update(Request $request, $facture_id)
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

            Technical_Task_Amount::where('facture_id', $facture_id)->delete();
            // dd($facture_id);
            $countTask = count($request->task_id);
            if ($countTask != NULL) {
                for ($i = 0; $i < $countTask; $i++) {
                    $service = new Technical_Task_Amount();
                    $service->technical_id = $request->technical_id;
                    $service->task_id = $request->task_id[$i];
                    $service->amount = $request->amount[$i];
                    $service->date = Carbon::now();
                    $service->facture_id = $facture_id;
                    $service->updated_by = Auth::user()->id;
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
        $data['dateNow'] = Carbon::now();
        $data['allData']  = DB::table('technical__task__amounts')
            ->where('technical_id', $technical_id)
            ->groupBy('date', 'facture_id')
            ->selectRaw('date,facture_id, GROUP_CONCAT(task_id) as task_ids, SUM(amount) as total_amount')
            // ->orderBy('date', 'desc')
            ->orderBy('facture_id', 'desc')
            ->get();
        // dd($data);
        $data['technical'] = Technical::find($technical_id);

        return view('frontend.service.details', $data);
    } //END METHOD

    public function detailsFacturePrint($facture_id)
    {
        $data  = DB::table('technical__task__amounts')
            ->where('facture_id', $facture_id)
            ->groupBy('date', 'facture_id')
            ->selectRaw('date,facture_id,GROUP_CONCAT(task_id) as task_ids, SUM(amount) as total_amount')
            ->get();
        $data['allData'] = $data[0];
        // dd($data['allData']);
        $pdf = PDF::loadView('frontend.pdf.servicePdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
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

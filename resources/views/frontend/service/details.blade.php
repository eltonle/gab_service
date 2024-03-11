@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">SERVICES</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Détails </a></li>
                    <li class="breadcrumb-item active">services</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-12">
        <div class="card">

            <div class="card-header ">
                <h3 class="card-title">Détails des Services
                    <a href="{{route('service.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des services</a>
                </h3>
            </div>

            <div class=" card-header mt-1 mr-5 ml-5">
                <h2 class="card-title ">Nom du Technicien: <span class="text-primary fw-bold ">{{ $technical->name}} </span>
                </h2>
            </div>



            <div class="card-body">
                @foreach($allData as $key => $item)
                <div class="mb-4 border-2 p-3">
                    <div class="d-flex justify-content-between mt-2 mr-5">
                        <div style="font-weight: bold; font-size: 16px;">
                            <h2 class="card-title ">
                                <h4 style="font-weight: bold; ">DATE: <span style="color: blue;">{{ date('d-M-Y', strtotime($item->date)) }}</span> </h4>
                            </h2>
                        </div>
                        <div class="float-right text-primary fw-bold" style="font-size: 16px;"> Facture №: {{$item->facture_id}}
                            <a href="{{route('service.facture',$item->facture_id)}}" title="imprimer" class="ml-6" target="_blank"><span style="color: green;"> <i class="fa fa-download"></i></span></a>
                            @php
                            $daten = date('Y-m-d', strtotime($dateNow));
                            $date = date('Y-m-d', strtotime($item->date));
                            @endphp
                            @if($daten == $date)
                            <a href="{{route('service.edit', $item->facture_id)}}" title="editer" class="ml-3"><i class="fa fa-edit"></i></a>
                            @endif
                        </div>
                    </div>
                    <!-- <h4 style="font-weight: bold; ">DATE: <span style="color: blue;">{{ date('d-M-Y', strtotime($item->date)) }}</span> </h4> -->
                    <!-- <p class="float-right pr-6">{{ $item->date }}</p> -->

                    <ul class="list-group mt-3">
                        @php
                        $taskIds = explode(',', $item->task_ids);
                        @endphp
                        @foreach ($taskIds as $taskId)
                        @php

                        $task = App\Models\Task::where('id', $taskId)->first();
                        $amount = App\Models\Technical_Task_Amount::where('task_id', $taskId)->where('date', $item->date)->where('facture_id', $item->facture_id)->first();

                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $task->name }}
                            <span class="">{{ number_format($amount->amount, 0, ',', ' ') }} FCFA</span>
                        </li>

                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between mt-2 mr-5">
                        <div style="font-weight: bold; font-size: 16px;">Total</div>
                        <div class="float-right text-success fw-bold" style="font-size: 16px;"> {{ number_format($item->total_amount, 0, ',', ' ') }} FCFA</div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')

@endsection

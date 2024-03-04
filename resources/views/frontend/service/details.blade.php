@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Services</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Details </a></li>
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

                <h3 class="card-title">Details des Services
                    <a href="{{route('service.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des services</a>
                </h3>

            </div>

            <div class="card-body">
                <h3><strong>Nom du Technicien :</strong> {{$allData['0']['technical']['name']}}</h3>
                <table class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Taches</th>
                            <th>Montant</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($allData as $key => $item)
                        <tr>
                            <td>Tach#.{{$key= $key + 1}}</td>
                            <td>{{$item['task']['name']}}</td>
                            <td>{{$item->amount}}</td>
                            <!-- <td>{{$item->amount}} </td>  -->

                        <tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')

@endsection
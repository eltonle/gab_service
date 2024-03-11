@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">FACTURATION</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Facture</a></li>
                    <li class="breadcrumb-item active">Recherche</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ">

                <h3 class="card-title">
                    Créer une Facture
                    <a href="{{route('invoice.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Factures</a>
                </h3>
            </div>


            <div class="card-body">


                <form method="GET" action="{{route('invoice.daily.pdf')}}" target="_blank" id="myForm">
                    <div class="row ">

                        <div class="form-group col-sm-4">
                            <label for="">Date de début</label>
                            <input type="date" name="start_date" id="start_date" class="form-control form-control-sm  @error('start_date') is-invalid @enderror">
                            @error('start_date')
                            <div class="red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" class="form-control form-control-sm  @error('end_date') is-invalid @enderror">
                            @error('end_date')
                            <div class="red">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-2" style="padding-top: 30px;">
                            <button class="btn btn-info  ">Rechercher</button>
                        </div>
                    </div>
                </form>

            </div>


        </div>




        @endsection

        @section('js')

        @endsection

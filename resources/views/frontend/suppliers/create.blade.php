@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">FOURNISSEURS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Fournisseur</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                    <a href="{{route('suppliers.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Fournisseurs</a>
                </h3>

                <!-- <div class="float-right"> <a href="{{route('suppliers.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter un Achat</a></div> -->
            </div>
            <div class="card-body">

                <h4 class="card-title ">Créer Fournisseur </h4><br>


                <form id="myForm" method="post" action="{{ route('suppliers.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="supplier_name" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                            <input name="supplier_name" class="form-control {{ $errors->has('supplier_name') ? 'is-invalid' : '' }}" type="text" id="supplier_name">
                            @error('supplier_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row mb-3">
                        <label for="supplier_email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input name="supplier_email" class="form-control {{ $errors->has('supplier_email') ? 'is-invalid' : '' }}" type="email" id="supplier_email">
                            @error('supplier_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->



                    <div class="row mb-3">
                        <label for="supplier_address" class="col-sm-2 col-form-label">Adresse</label>
                        <div class="col-sm-10">
                            <input name="supplier_address" class="form-control {{ $errors->has('supplier_address') ? 'is-invalid' : '' }}" type="text" id="supplier_address">
                            @error('supplier_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="supplier_phone" class="col-sm-2 col-form-label">Téléphone</label>
                        <div class="col-sm-10">
                            <input name="supplier_phone" class="form-control {{ $errors->has('supplier_phone') ? 'is-invalid' : '' }}" type="text" id="supplier_phone">
                            @error('supplier_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->




                    <!-- <input type="submit" class="btn  btn-outline-primary waves-effect waves-light" value="Enregistrer"> -->
                    <button type="submit" class="btn  btn-outline-primary waves-effect waves-light">Submit</button>
                </form>



            </div>
        </div>




        @endsection

        @section('js')

        @endsection
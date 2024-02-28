@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Fournisseurs</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Fournisseur</a></li>
                    <li class="breadcrumb-item active">Update</li>
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
                    <a href="{{route('suppliers.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Fournisseursr</a>
                </h3>

                <!-- <div class="float-right"> <a href="{{route('suppliers.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter un Achat</a></div> -->
            </div>
            <div class="card-body">

                <h4 class="card-title ">Update Fournisseur </h4><br>


                <form id="myForm" method="post" action="{{ route('suppliers.update',$item->id) }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="supplier_name" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                            <input name="supplier_name" class="form-control {{ $errors->has('supplier_name') ? 'is-invalid' : '' }}" value="{{$item->supplier_name}}" type="text" id="supplier_name">
                            @error('supplier_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row mb-3">
                        <label for="supplier_email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input name="supplier_email" class="form-control {{ $errors->has('supplier_email') ? 'is-invalid' : '' }}" value="{{$item->supplier_email}}" type="email" id="supplier_email">
                            @error('supplier_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->



                    <div class="row mb-3">
                        <label for="supplier_address" class="col-sm-2 col-form-label">Addresse</label>
                        <div class="col-sm-10">
                            <input name="supplier_address" class="form-control {{ $errors->has('supplier_address') ? 'is-invalid' : '' }}" value="{{$item->supplier_address}}" type="text" id="supplier_address">
                            @error('supplier_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="supplier_phone" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-10">
                            <input name="supplier_phone" class="form-control {{ $errors->has('supplier_phone') ? 'is-invalid' : '' }}" value="{{$item->supplier_phone}}" type="text" id="supplier_phone">
                            @error('supplier_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->




                    <!-- <input type="submit" class="btn  btn-outline-primary waves-effect waves-light" value="Enregistrer"> -->
                    <button type="submit" class="btn  btn-outline-primary waves-effect waves-light">Enregistrer</button>
                </form>



            </div>
        </div>




        @endsection

        @section('js')

        @endsection
@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Produits</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Produit</a></li>
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
                    <a href="{{route('products.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Produits</a>
                </h3>

                <!-- <div class="float-right"> <a href="{{route('suppliers.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter un Achat</a></div> -->
            </div>
            <div class="card-body">

                <h4 class="card-title ">Update Produit </h4><br>


                <form id="myForm" method="post" action="{{ route('products.update',$editData->id) }}">
                    @csrf

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label">Fournisseur</label>
                        <div class="col-sm-4">
                            <select class="form-control select2 " name="supplier_id">
                                <option value="">Select</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{($editData->supplier_id == $supplier->id)? "selected":""}}>{{$supplier->supplier_name}}</option>
                                @endforeach

                            </select>
                            @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Categorie</label>
                        <div class="col-sm-4">
                            <select class="form-control select2 " name="category_id">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{($editData->category_id == $category->id)? "selected":""}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                    </div><br>
                    <!-- end row -->

                    <div class="row">
                        <label class="col-sm-2 col-form-label">Unité</label>
                        <div class="col-sm-4">
                            <select class="form-control select2 " name="unit_id">
                                <option value="">Select</option>
                                @foreach($units as $unit)
                                <option value="{{$unit->id}}" {{($editData->unit_id == $unit->id)? "selected":""}}>{{$unit->name}}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="name" class="col-sm-2 col-form-label">Nom Produit</label>
                        <div class="col-sm-4">
                            <input name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{$editData->name}}" type="text" id="name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- <div class="col-sm-4">
                            <button type="submit" class="btn float-right  btn-outline-primary waves-effect waves-light">submit</button>
                        </div> -->
                    </div>
                    <br><br>
                    <!-- end row -->

                    <!-- <input type="submit" class="btn  btn-outline-primary waves-effect waves-light" value="Enregistrer"> -->
                    <button type="submit" class="btn  btn-outline-primary waves-effect waves-light">Submit</button>
                </form>



            </div>
        </div>




        @endsection

        @section('js')

        @endsection
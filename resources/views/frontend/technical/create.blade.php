@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Techniciens</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Technicien</a></li>
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
                    <a href="{{route('technical.index')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Listes des Techniciens</a>
                </h3>
            </div>
            <div class="card-body">

                <h4 class="card-title ">Creer Client </h4><br>


                <form id="myForm" method="post" action="{{ route('technical.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                            <input name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" id="name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" id="email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->



                    <div class="row mb-3">
                        <label for="address" class="col-sm-2 col-form-label">Addresse</label>
                        <div class="col-sm-10">
                            <input name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" id="address">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-10">
                            <input name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" id="phone">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- end row -->




                    <!-- <input type="submit" class="btn  btn-outline-primary waves-effect waves-light" value="Enregistrer"> -->
                    <button type="submit" class="btn  btn-outline-primary waves-effect waves-light">submit</button>
                </form>



            </div>
        </div>




        @endsection

        @section('js')

        @endsection
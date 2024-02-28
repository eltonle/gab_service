@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                    <li class="breadcrumb-item active">Change password</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Change Password Page </h4><br><br>
                @if(count($errors))
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger alert-dismissible fade show"> {{ $error}} </p>
                @endforeach

                @endif

                <form method="post" action="{{ route('update.password') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                            <input name="oldpassword" class="form-control" type="password" id="oldpassword">
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                            <input name="newpassword" class="form-control" type="password" id="newpassword">
                        </div>
                    </div>
                    <!-- end row -->



                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input name="confirm_password" class="form-control" type="password" id="confirm_password">
                        </div>
                    </div>
                    <!-- end row -->




                    <input type="submit" class="btn btn-outline-primary waves-effect waves-light" value="Change Password">
                </form>



            </div>
        </div>

        @endsection
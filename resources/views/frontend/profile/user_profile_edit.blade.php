@extends('layouts.app')


@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Edit Profile Page </h4>

                <form method="post" action="{{ route('store.profile') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input name="name" class="form-control" type="text" value="{{ $editData->name }}" id="example-text-input">
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">UserName</label>
                        <div class="col-sm-10">
                            <input name="username" class="form-control" type="text" value="{{ $editData->username }}" id="example-text-input">
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">User Email</label>
                        <div class="col-sm-10">
                            <input name="email" class="form-control" type="text" value="{{ $editData->email }}" id="example-text-input">
                        </div>
                    </div>
                    <!-- end row -->





                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image </label>
                        <div class="col-sm-10 ">
                            <div class="input-group">

                                <input name="profile_image" class="form-control" type="file" id="image">
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label"> </label>
                        <div class=" col-sm-10">
                            <img id="showImage" class="rounded avatar-lg" src="{{ (!empty($editData->profile_image))? url('upload/admin_images/'.$editData->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap">
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Profile"> -->
                    <input type="submit" class="btn btn-outline-primary waves-effect waves-light" value="Update Profile">
                </form>



            </div>
        </div>
    </div> <!-- end col -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection
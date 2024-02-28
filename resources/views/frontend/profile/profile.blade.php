@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <br><br>
            <center>

                <img class="rounded-circle avatar-xl" src="{{ (!empty($dataUser->profile_image))? url('upload/admin_images/'.$dataUser->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap">
            </center>
            <div class="card-body">
                <h4 class="card-title">Name : {{ $dataUser->name }} </h4>
                <hr>
                <br>
                <h4 class="card-title">User Email : {{ $dataUser->email }} </h4>
                <hr><br>
                <h4 class="card-title">User Name : {{ $dataUser->username }} </h4>
                <hr> <br>
                <a href="{{route('edit.profile')}}" class="btn btn-info btn-rounded waves-effect waves-light"> Edit Profile</a>
            </div>
        </div>
    </div>

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
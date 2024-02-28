@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Categories</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Category</li>
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

                <h3 class="card-title">Listes des Categories
                    <a href="{{route('categories.create')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter une categorie</a>
                </h3>

            </div>

            <div class="card-body">



                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($allData as $key => $item)
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                <a href="{{route('categories.edit', $item->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <!-- <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->
                                @php
                                $count_category = App\Models\Product::where('category_id', $item->id)->count();
                                @endphp
                                @if($count_category < 1) <button type="button" class="btn  btn-outline-danger waves-effect waves-light btn-sm delete-btn " data-supplier-id="{{ $item->id }}">
                                    <i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                            </td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionnez tous les boutons avec la classe delete-btn
        var deleteButtons = document.querySelectorAll('.delete-btn');

        // Attachez le gestionnaire d'événements à chaque bouton
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var supplierId = button.getAttribute('data-supplier-id');

                // Afficher la boîte de dialogue SweetAlert2 pour confirmation de la suppression
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si l'utilisateur confirme, rediriger vers la route de suppression avec l'ID du fournisseur
                        window.location.href = "/categories/delete/" + supplierId;
                    }
                });
            });
        });
    });
</script>
@endsection
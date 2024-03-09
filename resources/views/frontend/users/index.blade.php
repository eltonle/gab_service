@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Utilisateurs</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">utilisateur</li>
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

                <h3 class="card-title">Listes des Utilisateurs
                    <a href="{{route('users.create')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter un utilisateur</a>
                </h3>

            </div>

            <div class="card-body">



                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile_no</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($allData as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->address}}</td>
                            <td>
                                <a href="{{route('users.edit', $item->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <!-- <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->

                                @php
                                $count_customer = App\Models\Customer::where('created_by', Auth::user()->id)->count();
                                $count_invoice = App\Models\Invoice::where('created_by', Auth::user()->id)->count();
                                $count_product = App\Models\Product::where('created_by', Auth::user()->id)->count();
                                $count_purchase = App\Models\Purchase::where('created_by', Auth::user()->id)->count();
                                $count_supplier = App\Models\Supplier::where('created_by', Auth::user()->id)->count();
                                $count_task = App\Models\Task::where('created_by', Auth::user()->id)->count();
                                $count_tech = App\Models\Technical::where('created_by', Auth::user()->id)->count();
                                $count_unit = App\Models\Unit::where('created_by', Auth::user()->id)->count();
                                $count_user = App\Models\User::where('created_by', Auth::user()->id)->count();
                                @endphp
                                @if (empty($item->created_by) && empty($item->updated_by) && $count_customer <= 1 ) <button type="button" class="btn  btn-outline-danger waves-effect waves-light btn-sm delete-btn " data-supplier-id="{{ $item->id }}">
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
                        window.location.href = "/utilisateurs/delete/" + supplierId;
                    }
                });
            });
        });
    });
</script>
@endsection
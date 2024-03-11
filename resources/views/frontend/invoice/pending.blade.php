@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">FACTURATION</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Facture en Attente</li>
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

                <h3 class="card-title">Listes des Factures en Attente
                    <!-- <a href="{{route('invoice.create')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter une Facture</a> -->
                </h3>

            </div>

            <div class="card-body">


                <div class="table-responsive">


                    <table id="datatable" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>

                                <th> Facture No#</th>
                                <th>Nom Client</th>
                                <th>Date</th>
                                <th>Montant Facture</th>
                                <th>Status Facture</th>
                                <th>Actions</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($allData as $key => $item)
                            <tr>

                                <td>{{$item->invoice_no}}</td>
                                <td>
                                    {{$item['payment']['customer']['name']}} ({{$item['payment']['customer']['address']}}-{{$item['payment']['customer']['phone']}})
                                </td>
                                <td>{{date('d-m-Y',strtotime($item->date))}}</td>
                                <td>{{ number_format($item['payment']['total_amount'], 0, '.', ' ') }} FCFA</td>


                                <!-- <td>
                                    {{ number_format($item->unit_price, 0, '.', ' ') }} FCFA
                                </td> -->

                                <td>
                                    @if($item->status == '0')
                                    <span class="badge bg-danger">en attente</span>
                                    @elseif($item->status == '1')
                                    <span class="badge bg-success">approuvée</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- <a href="{{route('purchase.edit', $item->id)}}" class="btn btn-sm btn-outline-info waves-light"><i class="fas fa-pen-alt"></i></a> -->
                                    <!-- <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->
                                    @if($item->status=="0")
                                    <a href="{{route('invoice.approve', $item->id)}}" class="btn btn-sm btn-outline-info waves-light"><i class="fas fa-check-circle"></i></a>
                                    <button type="button" title="supprimer facture" class="btn  btn-outline-danger waves-effect waves-light btn-sm delete-btn " data-supplier-id="{{ $item->id }}">
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
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true
        });
    });
</script> -->
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
                        window.location.href = "/facturation/delete/" + supplierId;
                    }
                });
            });
        });
    });
</script>
@endsection

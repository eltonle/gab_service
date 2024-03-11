@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">PRODUITS</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Produit</li>
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
                <h3 class="card-title">Listes des Produits
                    <a href="{{route('stock.report.pdf')}}" target="_blank" class="float-right btn btn-success btn-sm"><i class="fa fa-download"></i> Telecharger fichier</a>
                </h3>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Fournisseurs</th>
                            <th>Categories</th>
                            <th>Produits</th>
                            <th>Stock d'entrée</th>
                            <th>Stock Sortie</th>
                            <th>Stocks</th>
                            <th>Unités</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allData as $key => $item)
                        @php
                        $buying_total = App\Models\Purchase::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('buying_qty');
                        $selling_total = App\Models\InvoiceDetail::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('selling_qty');
                        @endphp
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{$item->supplier['supplier_name']}}</td>
                            <td>{{$item->category['name']}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$buying_total}}</td>
                            <td>{{$selling_total}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->unit["name"]}}</td>
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
                        window.location.href = "/product/delete/" + supplierId;
                    }
                });
            });
        });
    });
</script>
@endsection

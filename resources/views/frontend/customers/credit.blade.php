@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Clients</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Crédits Client</li>
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

                <h3 class="card-title">Listes des Crédits
                    <a href="{{route('customers.credit.pdf')}}" target="_blank" class="float-right btn btn-success btn-sm"><i class="fa fa-download"></i> Telecharger</a>
                </h3>

            </div>

            <div class="card-body">


                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No_facture</th>
                            <th>Nom client</th>
                            <th>Date</th>
                            <th>Montant du crédit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                        $total_due = '0';
                        @endphp
                        @foreach ($data as $payment)
                        <tr>
                            <td>Facture No#{{ $payment['invoice']['invoice_no']}}</td>
                            <td>
                                {{ $payment['customer']['name'] }}(
                                {{ $payment['customer']['address'] }}_
                                {{ $payment['customer']['phone'] }})
                            </td>
                            <td>{{ date('d-M-Y',strtotime($payment['customer']['created_at'])) }}</td>
                            <td>{{ $payment->due_amount }} fcfa</td>
                            <td class="d-flex ">
                                <a href="{{ route('invoices.details.pdf',$payment->invoice_id) }}" target="_blank" title="details" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                            </td>
                            @php
                            $total_due += $payment->due_amount
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">

                    <tbody>
                        <td colspan="5" style="text-align: right;font-weight: bold;"><strong>Grand Total</strong></td>
                        <td style="color: red;"><strong>{{ $total_due }}</strong> fcfa</td>
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
                        window.location.href = "/customers/delete/" + supplierId;
                    }
                });
            });
        });
    });
</script>
@endsection

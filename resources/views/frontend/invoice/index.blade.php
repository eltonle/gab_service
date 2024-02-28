@extends('layouts.app')

@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Facturation</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Facture</li>
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

                <h3 class="card-title">Listes des Factures
                    <a href="{{route('invoice.create')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter une Facture</a>
                </h3>

            </div>

            <div class="card-body">


                <div class="table-responsive">


                    <table id="datatable" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>

                                <th> facture No#</th>
                                <th>Nom Client</th>
                                <th>Date</th>
                                <th>Montant Facture</th>
                                <th>Status</th>
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
                                    <span class="badge bg-success">approuveé</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- <a href="{{route('purchase.edit', $item->id)}}" class="btn btn-sm btn-outline-info waves-light"><i class="fas fa-pen-alt"></i></a> -->
                                    <!-- <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->
                                    @if($item->status=="1")
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-outline-success btn-sm waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                            <a class="dropdown-item" target="_blank" href="{{route('invoice.print',$item->id)}}" title="imprimer facture"><i class="fa fa-print"></i> imprimer</a>

                                            <!-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Static backdrop</button> -->
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-item-id="{{$item->id}}"><i class="fas fa-money-bill-alt"></i> Paiements</button>

                                            <!-- <a href="#" data-bs-target="#staticBackdrop" class="dropdown-item " data-item-id="{{$item->id}}" data-bs-toggle="modal"><i class="fas fa-money-bill-alt"></i> Paiements</a> -->
                                        </div>

                                    </div>
                                    <!-- <button type="button" title="supprimer" class="btn  btn-outline-danger waves-effect waves-light btn-sm delete-btn " data-supplier-id="{{ $item->id }}">
                                        <i class="fa fa-print"></i>
                                    </button> -->
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


<!-- MODAL PAIEMENTS -->
<div class="col-sm-6 col-md-4 col-xl-3">
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-center" id="staticBackdropLabel">Effectuer paiement</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div id="result-container" style="margin-left:15px ;">
                    <!-- Le résultat sera affiché ici -->
                </div>

                <form action="" method="post" id="myformPayment">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Saisir un Montant</label>
                            <input class="form-control" id="paidAmountInput" name="paid_amount" type="number" placeholder="Default input">
                        </div>
                    </div>
                    <div class="modal-footer  ">
                        <button type="button" class="btn btn-light waves-effect " data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success waves-effect waves-light ">Payé</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--END MODAL PAIEMENTS -->

@endsection


@section('js')
<script>
    $(document).ready(function() {
        $('.dropdown-item').on('click', function(e) {
            e.preventDefault();
            var itemId = $(this).data('item-id');
            console.log(itemId);
            $.ajax({
                url: '{{ route("getPayment") }}',
                type: 'GET',
                data: {
                    itemId: itemId
                },
                success: function(response) {
                    // Traitement de la réponse AJAX
                    console.log(response.data);
                    displayResult(response.data);
                },
                error: function(error) {
                    // Gestion des erreurs
                    console.error(error);
                }
            });
        });

        function displayResult(data) {
            // Obtenez le conteneur où vous souhaitez afficher le tableau
            var resultContainer = $('#result-container');

            // Créez un tableau HTML
            var tableHTML = '<table border="1" width ="100%"><tr><th> Montant Total</th><th>Montant Paye</th><th> Montant Du</th></tr>';


            tableHTML += '<tr><td id="total">' + data.total_amount.toLocaleString() + ' FCFA</td><td id="paid">' + data.paid_amount.toLocaleString() + ' FCFA</td><td id="due">' + data.due_amount.toLocaleString() + ' FCFA</td></tr>';


            // Fermez le tableau
            tableHTML += '</table>';

            // Ajoutez le tableau au conteneur
            resultContainer.html(tableHTML);
        }
    });
</script>
<script>
    $(document).ready(function() {


        $('#paidAmountInput').change(function() {
            // Obtenez la valeur saisie
            var enteredAmount = parseFloat($(this).val());

            var valeurDue = parseInt($("#due").text(), 10);
            var valeurPaid = parseInt($("#paid").text(), 10);
            var valeurTotal = parseInt($("#total").text(), 10);

            // Comparez avec la valeur de data.due_amount
            if (enteredAmount < valeurDue) {
                alert('Le montant payé est inférieur au montant dû.');
            } else if (enteredAmount > valeurDue) {
                alert('Le montant payé est supérieur au montant dû.');
            } else {
                alert('Le montant payé est égal au montant dû.');
            }
        });
    })
</script>
@endsection
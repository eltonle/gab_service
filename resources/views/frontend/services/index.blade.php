@extends('layouts.app')

@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Services</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Service</li>
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

                <h3 class="card-title">Listes des Services
                    <a href="{{route('service.create')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Ajouter une Facture</a>
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
                                <th>Paiement </th>
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
                                    @if ($item['payment']['paid_status'] == 'partial_paid')
                                    <span class="badge" style="background: #43BD00;color:white; padding: 3px;">
                                        <i class="fa fa-burn"></i> Partiellement</span>
                                    @elseif ($item['payment']['paid_status'] == 'full_due')
                                    <span class="badge" style="background:  #B61418; color:white; padding: 3px;">
                                        <i class="fas fa-thumbs-down "></i> Non Payer</span>
                                    @elseif ($item['payment']['paid_status']=='full_paid')
                                    <span class="badge" style="background: #36BEA6; color:white; padding: 3px;">
                                        <i class="fas fa-thumbs-up"></i> Payer</span>
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
                                            <a class="dropdown-item" target="_blank" href="{{route('service.print',$item->id)}}" title="imprimer facture"><i class="fa fa-print"></i> imprimer</a>

                                            <!-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Static backdrop</button> -->
                                            <button type="button" class="dropdown-item  edit-invoice-link " data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{$item->id}}"><i class="fas fa-money-bill-alt"></i> Paiements</button>

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
                    <button type="button" class="btn-close " style="margin-right: 5px;" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>

                <div class="modal-body">
                    <div class="text-center" id="progress-indicator-loader" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Montant payé</th>
                            </tr>
                        </thead>
                        <tbody id="payment-table-body">
                            <!-- Les paiements seront ajoutés ici via AJAX -->
                        </tbody>

                    </table>
                    <hr>
                    <div style="text-align: center;">
                        <h6 style="font-style: italic;">information de paiements</h6>
                    </div>
                    <div style="text-align: center;">
                        <span style="font-style: italic; color:green;font-weight: bold;" id="payment-message"></span>
                    </div>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Montant Total</th>
                                <th>Montant Paye</th>
                                <th>Reste a Payer</th>
                            </tr>
                        </thead>
                        <tbody id="payment-report">
                            <!-- Les paiements seront ajoutés ici via AJAX -->
                        </tbody>
                    </table>
                    <div id="payDiv">
                        <form id="my-form">
                            @csrf
                            <div class="">
                                <input type="hidden" id="invoice-id-input" name="invoice_id" value="">
                                <div class="w-100 mb-2">
                                    <input type="number" min="100" name="paid_amount" id="paid-amount-input" class="form-control " placeholder="Effectuer un paiement">
                                    <span id="comparison-message" class="text-danger text-xs italic"></span>
                                </div>
                                <button type="submit" id="submit-button" class="btn btn-outline-success waves-effect waves-light w-100">Soumettre</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer  float-right">
                    <button type="button" class="btn btn-light waves-effect " data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-outline-success waves-effect waves-light ">Payé</button> -->
                </div>

            </div>
        </div>
    </div>
</div>
<!--END MODAL PAIEMENTS -->

@endsection


@section('js')
<!-- les paiements modal -->
<script>
    $(document).ready(function() {
        $(".edit-invoice-link").on("click", function(event) {
            event.preventDefault();
            // Affichez l'indicateur de chargement
            $("#progress-indicator-loader").show();
            var btn = $("#paid_amount").val();
            console.log(btn);
            if (!btn) {
                $('#submit-button').prop('disabled', true);
            }

            var invoiceId = $(this).data("id");

            var tbody = $("#payment-table-body");
            var tbodyPay = $("#payment-report");
            tbody.empty();
            tbodyPay.empty();
            console.log(invoiceId);
            // Effectuer la requête AJAX pour récupérer les détails de la facture
            setTimeout(function() {
                $.ajax({
                    url: "{{ route('service_modalDetails') }}", // Remplacez par l'URL de votre route AJAX
                    type: "GET",
                    data: {
                        invoice_id: invoiceId
                    },
                    success: function(data) {
                        $("#progress-indicator-loader").hide();
                        console.log(data);

                        let index = 1
                        // Ajouter les données des paiements au tbody
                        data.payments.forEach(function(payment) {
                            var formattedAmount = parseFloat(payment.current_paid_amount).toLocaleString('fr-FR', {
                                style: 'currency',
                                currency: 'XOF'
                            });
                            var row = '<tr>' +
                                '<td>' + index++ + '</td>' +
                                '<td>' + payment.date + '</td>' +
                                '<td>' + formattedAmount + '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });
                        var totalAmount = parseFloat(data.fullDataPay.total_amount).toLocaleString('fr-FR', {
                            style: 'currency',
                            currency: 'XOF'
                        });
                        var PayAmount = parseFloat(data.fullDataPay.paid_amount).toLocaleString('fr-FR', {
                            style: 'currency',
                            currency: 'XOF'
                        });
                        var dueAmount = parseFloat(data.fullDataPay.due_amount).toLocaleString('fr-FR', {
                            style: 'currency',
                            currency: 'XOF'
                        });
                        var pay = '<tr>' +
                            '<td>' + totalAmount + '</td>' +
                            '<td>' + PayAmount + '</td>' +
                            '<td style="color: red;">' + dueAmount + '</td>' +
                            '</tr>';

                        tbodyPay.append(pay);
                        // Retirer les points de progression une fois les données chargées

                        $("#invoice-id-input").val(data.invoiceId);

                        var dueAmountCompare = parseFloat(data.fullDataPay.due_amount);
                        var submitButton = $('#submit-button');

                        if (data.fullDataPay.total_amount > data.fullDataPay.paid_amount) {
                            // Si nbre1 est supérieur à nbre2, affichez la div
                            $("#payDiv").show();
                        } else if (data.fullDataPay.total_amount == data.fullDataPay.paid_amount) {
                            // Si nbre1 est égal à nbre2, masquez la div
                            $("#payDiv").hide();
                        }

                        $('#paid-amount-input').on('input', function() {
                            var paidAmount = parseFloat($(this).val());
                            var comparisonMessage = $('#comparison-message');


                            // Vérifier si le champ est vide ou le montant est supérieur
                            if (paidAmount > dueAmountCompare) {
                                comparisonMessage.html('Le montant saisi est invalide ou supérieur au montant dû.');
                                submitButton.prop('disabled', true);
                            } else if (isNaN(paidAmount)) {
                                comparisonMessage.html('Veuillez saisir un montant.');
                                submitButton.prop('disabled', true);
                            } else if (paidAmount != 0 || paidAmount <= dueAmountCompare) {
                                comparisonMessage.html('');
                                submitButton.prop('disabled', false);
                            } else {
                                comparisonMessage.html('');
                                submitButton.prop('disabled', false);
                            }
                        });

                    }
                });
            }, 1000); // Délai de 2 secondes (2000 ms)
        });
    });
</script>

<!-- soumttre PAYMENT -->
<script>
    $(document).ready(function() {
        $("#my-form").on("submit", function(e) {
            e.preventDefault();

            var submitButton = $('#submit-button');
            submitButton.html('En cours...');

            var invoiceId = $("#invoice-id-input").val();
            var paidAmount = $("#paid-amount-input").val();
            console.log(invoiceId);
            console.log(paidAmount);

            $.ajax({
                url: "{{ route('service_update-payment') }}", // Remplacez par l'URL de votre route de mise à jour
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    invoice_id: invoiceId,
                    paid_amount: paidAmount
                },
                success: function(data) {
                    submitButton.html('Soumettre');
                    $("#paid-amount-input").val("");
                    // Afficher le message "Paiement effectué" dans le span
                    $("#payment-message").text("Paiement effectué ✔️").fadeIn();

                    // Après deux secondes, masquer le message
                    setTimeout(function() {
                        $("#payment-message").fadeOut();
                        location.reload();
                    }, 2000);

                },
                error: function(error) {
                    // En cas d'erreur, remettre le texte original sur le bouton
                    submitButton.html('Soumettre');

                    // Gérer l'erreur
                }
            });
        });
    });
</script>

@endsection
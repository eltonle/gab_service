@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Clients</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Recherche </a></li>
                    <li class="breadcrumb-item active">Client</li>
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

                <h3 class="card-title">Selectionner critere
                    <!-- <a href="{{route('stock.report.pdf')}}" target="_blank" class="float-right btn btn-success btn-sm"><i class="fa fa-download"></i> Telecharger fichier</a> -->
                </h3>

            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <strong>Bilan de Crédit Client</strong>
                        <input type="radio" name="customer_wise_report" value="customer_wise_credit" class="search_value"> &nbsp;&nbsp;
                        <strong>Bilan de paiement Client</strong>
                        <input type="radio" name="customer_wise_report" value="customer_wise_paid" class="search_value">
                    </div>
                </div>
                <div class="show_credit" style="display: none;">
                    <form method="GET" action="{{ route('customers.wise.credit.report') }}" target="_blank">
                        <div class="form-row">
                            <div class="col-sm-8">
                                <label for="">Nom du client Crédit</label>
                                <select name="customer_id" value="supplier_value" class="form-control select2">
                                    <option value="">nom du client</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}({{ $customer->phone }}-{{ $customer->address }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4" style="padding-top: 30px;">
                                <button class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="show_paid" style="display: none;">
                    <form method="GET" action="{{ route('customers.wise.paid.report') }}" target="_blank">
                        <div class="form-row">
                            <div class="col-sm-8">
                                <label for="">Nom du client Payé</label>
                                <select name="customer_id" value="" class="form-control select2">
                                    <option value="">nom du client</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}({{ $customer->mobile_no }}-{{ $customer->address }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4" style="padding-top: 30px;">
                                <button class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')
<script>
    $(document).on('change', '.search_value', function() {
        var search_value = $(this).val();
        if (search_value == 'customer_wise_credit') {
            $('.show_credit').show();
        } else {
            $('.show_credit').hide();
        }
        if (search_value == 'customer_wise_paid') {
            $('.show_paid').show();
        } else {
            $('.show_paid').hide();
        }
    })
</script>
@endsection
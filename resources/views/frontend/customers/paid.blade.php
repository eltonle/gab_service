@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">CLIENTS</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Listes </a></li>
                    <li class="breadcrumb-item active">Paiement Client</li>
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

                <h3 class="card-title">Listes des Paiements
                    <a href="{{route('customers.paid.pdf')}}" target="_blank" class="float-right btn btn-success btn-sm"><i class="fa fa-download"></i> Telecharger</a>
                </h3>

            </div>

            <div class="card-body">


                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No_facture</th>
                            <th>Nom client</th>
                            <th>Date</th>
                            <th>Montant Payé</th>
                            <th>Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                        $total_paid = '0';
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
                            <td> {{ number_format( $payment->paid_amount  , 0, '.', ' ') }} FCFA</td>
                            <td class="d-flex ">
                                <a href="{{ route('invoices.details.pdf',$payment->invoice_id) }}" target="_blank" title="details" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                            </td>
                            @php
                            $total_paid += $payment->paid_amount
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">

                    <tbody>
                        <td colspan="5" style="text-align: right;font-weight: bold;"><strong>Grand Total</strong></td>
                        <td style="color: red;"><strong>{{ number_format( $total_paid  , 0, '.', ' ') }}</strong> FCFA</td>
                    </tbody>
                </table>


            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')

@endsection

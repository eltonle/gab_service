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

                <h3 class="card-title">FACTURE No#{{$invoice->invoice_no}}-({{date('d-m-Y',strtotime($invoice->date))}})
                    <a href="{{route('invoice.pending')}}" class="float-right btn btn-success btn-sm"><i class="fa fa-list"></i> Factures en Attentes</a>
                </h3>

            </div>

            <div class="card-body">
                @php
                $payment = App\Models\Payment::where('invoice_id',$invoice->id)->first();
                @endphp
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="15%">
                                <p><strong style="color:red;">Infos Client </strong></p>
                            </td>
                            <td width="25%">
                                <p><strong>Name :</strong> {{ $payment['customer']['name'] }}</p>
                            </td>
                            <td width="25%">
                                <p><strong>Mobile No :</strong>{{ $payment['customer']['mobile_no'] }}</p>
                            </td>
                            <td width="35%">
                                <p><strong>Address :</strong>{{ $payment['customer']['address'] }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%"></td>
                            <td width="85%" colspan="3">
                                <p><strong>Description : </strong>{{ $invoice->description }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form method="post" action="{{ route('invoice.approve.store',$invoice->id) }}">
                    @csrf
                    <table border="1" width="100%" class="table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>NI</th>
                                <th>Categorie</th>
                                <th>Articles</th>
                                <th class="text-center" style="background: #ddd;padding: 1px;">
                                    Stock Courant
                                </th>
                                <th>Quantite</th>
                                <th>Price Unitaire </th>
                                <th> Prix Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sum_total = '0';
                            @endphp
                            @foreach ($invoice['invoice_details'] as $key => $details )
                            <tr class="text-center">
                                <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                                <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                                <input type="hidden" name="selling_qty[{{ $details->id }}]" value="{{ $details->selling_qty }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $details['category']['name'] }}</td>
                                <td>{{ $details['product']['name'] }}</td>
                                <td class="text-center" style="background: #ddd;padding: 1px;">{{ $details['product']['quantity'] }}</td>
                                <td>{{ $details->selling_qty }}</td>
                                <td>{{number_format( $details->unit_price , 0, '.', ' ') }} FCFA</td>
                                <td>{{ number_format($details->selling_price, 0, '.', ' ') }} FCFA</td>
                            </tr>
                            @php
                            $sum_total = $sum_total + $details->selling_price
                            @endphp
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total</strong></td>
                                <td class="text-center"><strong>{{ number_format($sum_total, 0, '.', ' ') }} FCFA</strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Remise</td>
                                <td class="text-center">
                                    <strong>
                                        @if ($payment->discount_amount === NULL)
                                        0
                                        @else
                                        {{ number_format($payment->discount_amount, 0, '.', ' ') }}
                                        @endif FCFA
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Montant paye</td>
                                <td class="text-center"><strong>{{ number_format($payment->paid_amount, 0, '.', ' ') }} FCFA</strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Montant Du</td>
                                <td class="text-center "><strong style="color: red;">{{ number_format($payment->due_amount, 0, '.', ' ')}} FCFA</strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                                <td class="text-center"><strong>{{ number_format($payment->total_amount, 0, '.', ' ')}} FCFA</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-outline-success waves-effect  mt-2">Approuver la facture</button>
                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection

@section('js')

@endsection
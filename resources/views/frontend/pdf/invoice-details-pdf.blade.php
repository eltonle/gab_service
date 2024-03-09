<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture</title>
    <style>
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                   <tbody>
                        <tr>
                            <td><img src="assets/images/logo-sm-dark.png" heigth="200" width="250">

                            <td>
                                 <span style="font-size: 20px;background: #ddd;">Gabson Services </span>
                                 <p>Adresse : Port-Gentil-Gabon<br> (Balaran Centre social)</p>
                                 <span>Service_mobile : <strong>074 90 77 96<br>074 29 64 71 - 062 67 52 24</strong></span>
                            </td>
                            <td><strong>Facture No#{{ $invoice->invoice_no }}</strong></td>
                            <td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <hr style="margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-12">
                <table>
                    <tbody>
                        <tr>
                            <td width="40%"></td>
                            <td> <u><strong><span style="font-size: 17px;">Facture detailleé client</span></strong></u></td>
                            <td width="20%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td colspan="4" style="font-size: 15px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"><strong>Informations client:</strong></td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Nom :</strong>{{ $payment['customer']['name'] }}</td>
                            <td width="30%"><strong>Mobile :</strong>{{ $payment['customer']['phone'] }}</td>
                            <td width="40%"><strong>Address :</strong>{{ $payment['customer']['address'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <table border="1" width="100%" style="margin-bottom: 10px;" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>NI</th>
                            <!-- <th>Category</th>  -->
                            <th>Article</th>
                            <th>Quantite</th>
                            <th>Prix unitaire</th>
                            <th>Prix total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sum_total = '0';
                        $invoice_details = App\Models\InvoiceDetail::where('invoice_id',$payment->invoice_id)->get();
                        @endphp
                        @foreach ($invoice_details as $key => $details )
                        <tr class="text-center">
                            {{-- <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                            <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                            <input type="hidden" name="selling-qty[{{ $details->id }}]" value="{{ $details->selling_qty }}"> --}}
                            <td>{{ $key+1 }}</td>
                            {{-- <td>{{ $details['category']['name'] }}</td> --}}
                            <td>{{ $details['product']['name'] }}</td>
                            <td>{{ $details->selling_qty }} </td>
                            <td>{{ number_format($details->unit_price, 0, '.', ' ')}} FCFA</td>
                            <td>{{ number_format($details->selling_price , 0, '.', ' ')}} FCFA</td>
                        </tr>
                        @php
                        $sum_total = $sum_total + $details->selling_price
                        @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong>{{ number_format($sum_total  , 0, '.', ' ')}} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Remise</td>
                            <td class="text-center">
                                <strong>
                                    @if ($payment->discount_amount === NULL)
                                    0
                                    @else
                                    {{ $payment->discount_amount }}
                                    @endif FCFA

                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Montant payé</td>
                            <td class="text-center"><strong>{{ number_format($payment->paid_amount  , 0, '.', ' ') }} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Montant dû</td>
                            <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}">
                            <td class="text-center"><strong style="color: red;">{{ number_format($payment->due_amount , 0, '.', ' ') }} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                            <td class="text-center"><strong>{{ number_format($payment->total_amount  , 0, '.', ' ')}} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: center; font-weight: bold;"><strong>Récapitulatif payant</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center;"><strong>Date</strong></td>
                            <td colspan="3" style="text-align: center;"><strong>Montant</strong></td>
                        </tr>
                        @php
                        $payment_details = App\Models\PaymentDetail::where('invoice_id', $payment->invoice_id)->get();
                        @endphp
                        @foreach ($payment_details as $details)
                        <tr>
                            <td colspan="3" style="text-align: center;">{{ date('d-M-Y',strtotime($details->date)) }}</td>
                            <td colspan="3" style="text-align: center;">{{number_format($details->current_paid_amount , 0, '.', ' ')}} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>

        <div class="row">
            <div class="col-md-12">


                @php
                $date = new DateTime('now', new DateTimezone('Africa/Douala'));
                @endphp
                <i>Print time : {{ $date->format('F j, Y, H:i:s') }}</i><br>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr style="margin-bottom: 0px;">
                <table border="0" width="100%">
                    <tbody>
                        <tr>
                            <td style="width:40%;">
                                <p style="text-align: center;margin-left: 20px;">Douala: bp cite</p>
                            </td>
                            <td style="width:20%;"></td>
                            <td style="width:40%;text-align: center;">
                                <p style="text-align: center;">Signature client</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</body>

</html>

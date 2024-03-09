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
                            <td width="47%"></td>
                            <td> <u><strong><span style="font-size: 17px;">Facture client</span></strong></u></td>
                            <td width="30%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @php
                $payment = App\Models\Payment::where('invoice_id',$invoice->id)->first();
                @endphp
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="30%"><strong>Nom :</strong>{{ $payment['customer']['name'] }}</td>
                            <td width="30%"><strong>Mobile :</strong>{{ $payment['customer']['phone'] }}</td>
                            <td width="40%"><strong>Address :</strong>{{ $payment['customer']['address'] }}</td>
                        </tr>
                    </tbody>
                </table>
                <table border="1" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>NI</th>
                            <!-- <th>Category</th> -->
                            <th>Article</th>
                            <th>Quantite</th>
                            <th>Prix unitaire</th>
                            <th>Prix total</th>
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
                            <input type="hidden" name="selling-qty[{{ $details->id }}]" value="{{ $details->selling_qty }}">
                            <td>{{ $key+1 }}</td>
                            <!-- <td>{{ $details['category']['name'] }}</td>  -->
                            <td>{{ $details['product']['name'] }}</td>
                            <td>{{ $details->selling_qty }}</td>
                            <td>{{ $details->unit_price }} FCFA</td>
                            <td>{{ $details->selling_price }} FCFA</td>
                        </tr>
                        @php
                        $sum_total = $sum_total + $details->selling_price
                        @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong>{{ $sum_total }} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Remise</td>
                            <td class="text-center"><strong>
                                    @if ($payment->discount_amount === NULL)
                                    0
                                    @else
                                    {{ $payment->discount_amount }}
                                    @endif
                                    FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Montant payé</td>
                            <td class="text-center"><strong>{{ $payment->paid_amount }} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Montant du</td>
                            <td class="text-center"><strong style="color: red;">{{ $payment->due_amount }} FCFA</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                            <td class="text-center"><strong>{{ $payment->total_amount }} FCFA</strong></td>
                        </tr>
                    </tbody>
                </table>
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
                                <p style="text-align: center;margin-left: 20px;">Port-Gentil - Balaran (Centre Social) </p>
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

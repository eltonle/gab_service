<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        td {
            text-align: center;
        }
    </style>
    <title>Rapport Quotidien PDF</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table width="100%">
                    <tr>
                        <td><img src="assets/images/logo-sm-dark.png" heigth="200" width="250">
                        <td>
                        <td width="50%">
                            <h4 class="" style="font-size: 26px">Date du jour:<span style="font-size: 18px"> {{ $date
                                    }}</span></h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td width="29%"></td>
                        <td width=""><strong>Rapport d'Achat du {{ date('d-M-Y',strtotime($start_date)) }} Au {{
                                date('d-M-Y',strtotime($end_date)) }}</strong></td>
                        <td width="15%"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <table id="datatable" border="1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>No_achat</th>
                        <th>Date</th>
                        <th>Nom Produit</th>
                        <th>Quantité</th>
                        <th>Prix U.</th>
                        <th>Prix achat</th>
                    </tr>
                </thead>


                <tbody>
                    @php
                    $total_sum = '0';
                    @endphp
                    @foreach($allData as $key => $item)
                    <tr>
                        <td>{{ $key + 1}}</td>
                        <td>{{$item->purchase_no}}</td>
                        <td>{{date('d-m-Y',strtotime($item->date))}}</td>
                        <td>{{$item['product']['name']}}</td>
                        <td>
                            {{number_format($item->buying_qty, 0, ',', ' ')}}
                            {{$item['product']['unit']['name']}}

                        </td>
                        <td>
                            {{ number_format($item->unit_price, 0, '.', ' ') }} FCFA
                        </td>
                        <td>
                            {{ number_format($item->buying_price, 0, '.', ' ') }} FCFA
                        </td>

                        @php
                        $total_sum += $item->buying_price ;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                        <td colspan="5" style="text-align: right;"><strong>Grand total</strong></td>
                        <td>{{ number_format($total_sum, 0, '.', ' ') }} FCFA</td>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div>
        <hr style="margin-bottom: 0px;">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="width: 40%;">
                    </td>
                    <td style="width: 25%;"></td>
                    <td style="width: 40px; text-align: center;">
                        <p style="text-align: center; font-weight: bold"> Signature du Responsable</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>



</body>

</html>

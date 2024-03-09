<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>
        td {
            text-align: center;
        }
    </style>
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
                            {{ $date
                                    }}
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
                        <td width="43%"></td>
                        <td width=""><strong>Rapport De Stock Fournisseur</strong></td>
                        <td width="15%"></td>

                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div style="margin-bottom: 7px;margin-top: 7px;">

                    <strong>Nom du Fournissaeur : </strong> {{$allData['0']['supplier']['supplier_name']}}
                </div>

                <table id="exemple1" border="1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Categorie</th>
                            <th>Nom Produit</th>
                            <th>Stock d'entreé</th>
                            <th>Stock Sortie</th>
                            <th>Stock</th>
                            <th>Unité</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allData as $key => $product)

                        @php
                        $buying_total = App\Models\Purchase::where('category_id',$product->category_id)->where('product_id',$product->id)->where('status','1')->sum('buying_qty');
                        $selling_total = App\Models\InvoiceDetail::where('category_id',$product->category_id)->where('product_id',$product->id)->where('status','1')->sum('selling_qty');

                        @endphp

                        <tr>
                            <td> <span class="" style="background: #ddd; font-weight: 900"> № #{{
                                $key+1
                                }}</span>
                            </td>
                            <td>
                                {{ $product['category']['name'] }}
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{$buying_total}}</td>
                            <td>{{$selling_total}}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product['unit']['name'] }}</td>


                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
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

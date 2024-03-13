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
                        <td width="20%"><img src="assets/images/logo-sm-dark.png" heigth="200" width="250">

                        <td width="35%">
                            <span style="font-size: 20px;background: #ddd;">Gabson Services </span>
                            <p>Adresse : Port-Gentil-Gabon<br> (Balaran Centre social)</p>
                            <span>Service_mobile : <strong>074 90 77 96<br>074 29 64 71 - 062 67 52 24</strong></span>
                        </td>
                        <td width="45%"><strong>Facture № #{{$allData->facture_id}}</strong> <br> <span> Date : {{ date('d-M-Y',strtotime( $allData->date))
                                    }}</span></td>
                        <td>
                    </tr>


                </table>
            </div>
        </div>
        <br>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td width="47%">

                        </td>
                        <td width=""><strong>Facture Tache Effectuée </strong></td>
                        <td width="15%"></td>

                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">


                <table id="exemple1" border="1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tache № .</th>
                            <th>Tache</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $taskIds = explode(',', $allData->task_ids);
                        @endphp

                        @foreach ($taskIds as $key => $taskId)

                        @php
                        $task = App\Models\Task::where('id', $taskId)->first();
                        $amount = App\Models\Technical_Task_Amount::where('task_id', $taskId)->where('date', $allData->date)->where('facture_id', $allData->facture_id)->first();
                        @endphp

                        <tr>
                            <td> <span class="" style="background: #ddd; font-weight: 900"> №#{{
                                $key+1
                                }}</span>
                            </td>
                            <td>
                                {{ $task->name }}
                            </td>
                            <td>{{ number_format($amount->amount, 0, ',', ' ') }} FCFA</td>



                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong>{{ $allData->total_amount }} FCFA</strong></td>
                        </tr>

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
@extends('layouts.app')
@section('content')


<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">TABLEAU DE BORD</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau </a></li>
                    <li class="breadcrumb-item active">Bord</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="row mb-2">
    <div>
        <div class="text-right filtre">
            <label for="year">Filtre :</label>
            <select id="year">
                <!-- Remplacez les années par les années disponibles dans votre base de données -->
                <option value="day">aujourd'hui</option>
                @if (auth()->user()->isAdmin())
                <option value="7">7 derniers jours</option>
                <option value="30">30 derniers jours</option>
                <option value="lastMonth">Le mois dernier</option>
                <option value="thisMonth">Le mois en cours</option>
                <option value="thisYear"> Année en cours</option>
                <option value="lastYear">Année derniere</option>
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2"> Total versements net</p>
                        <h4 class="mb-2" id="totalPayeDiv"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2"> Total somme perçue</p>
                        <h4 class="mb-2" id="totalNetPayeDiv"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total somme credit</p>
                        <h4 class="mb-2" id="totalDueDiv"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total somme remise</p>
                        <h4 class="mb-2" id="totalDetailsPaiementsDiv"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<!-- SERVICE -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2"> Total net service</p>
                        <h4 class="mb-2" id="totalPayeDiv1"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2"> Total perçue service</p>
                        <h4 class="mb-2" id="totalNetPayeDiv1"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total credit service</p>
                        <h4 class="mb-2" id="totalDueDiv1"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total remise service</p>
                        <h4 class="mb-2" id="totalDetailsPaiementsDiv1"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="mdi mdi-currency-usd font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->


<!-- end row -->





<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">

                <!-- <h4 class="card-title mb-4">Bar de progression</h4> -->


                <canvas id="myChart" height="200"></canvas>

            </div>
        </div>
    </div> <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <!-- <h4 class="card-title mb-4">Column Chart</h4> -->

                <!-- <canvas id="lineChart" height="300"></canvas> -->
                <canvas id="myChartSecond" height="280" width="479" style="display: block; width: 479px; height: 260px;" class="chartjs-render-monitor"></canvas>
            </div>
        </div><!--end card-->
    </div>
</div>
<!-- end row -->



@endsection

@section('js')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var ctxSecond = document.getElementById('myChartSecond').getContext('2d');
    var myChart;
    var myChartSecond;


    function updateChart(year) {
        // Fonction pour mettre à jour le graphique en fonction de l'année sélectionnée
        fetch(`/home/${year}`)
            .then(response => response.json())
            .then(data => {
                console.log(year);
                console.log(data);
                // Accédez aux données dans l'objet JSON
                var transactions = data[0];
                var details = data[1];
                var transactions1 = data[2];
                var details1 = data[3];

                // Organisez les données par mois
                var months = Array.from({
                    length: 12
                }, (_, i) => i + 1);
                var payeData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.paid_amount, 0));
                var payeData1 = months.map(month => transactions1.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.paid_amount, 0));


                var dueData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.due_amount, 0));
                var dueData1 = months.map(month => transactions1.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.due_amount, 0));


                var netPayeData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.total_amount, 0));
                var netPayeData1 = months.map(month => transactions1.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.total_amount, 0));


                var discounts = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.discount_amount, 0));
                var discounts1 = months.map(month => transactions1.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.discount_amount, 0));


                var details_paiements = months.map(month => details.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.current_paid_amount, 0));
                var details_paiements1 = months.map(month => details1.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.current_paid_amount, 0));



                var totalPaye = payeData.reduce((acc, cur) => acc + cur, 0);
                var totalPaye1 = payeData1.reduce((acc, cur) => acc + cur, 0);


                var totalDue = dueData.reduce((acc, cur) => acc + cur, 0);
                var totalDue1 = dueData1.reduce((acc, cur) => acc + cur, 0);


                var totalNetPaye = netPayeData.reduce((acc, cur) => acc + cur, 0);
                var totalNetPaye1 = netPayeData1.reduce((acc, cur) => acc + cur, 0);


                var totalDiscounts = discounts.reduce((acc, cur) => acc + cur, 0);
                var totalDiscounts1 = discounts1.reduce((acc, cur) => acc + cur, 0);


                var totalDetails = details_paiements.reduce((acc, cur) => acc + cur, 0);
                var totalDetails1 = details_paiements1.reduce((acc, cur) => acc + cur, 0);


                console.log(totalPaye);

                // Mettez à jour le graphique Chart.js
                if (myChart) {
                    myChart.destroy();
                }
                if (myChartSecond) {
                    myChartSecond.destroy();
                }


                // Utilisez jQuery pour mettre à jour le contenu des div
                $("#totalPayeDiv").text(totalNetPaye.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalPayeDiv1").text(totalNetPaye1.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));


                $("#totalDueDiv").text(totalDue.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalDueDiv1").text(totalDue1.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));


                $("#totalNetPayeDiv").text(totalDetails.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalNetPayeDiv1").text(totalDetails1.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));


                $("#totalDetailsPaiementsDiv").text(totalDiscounts.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));

                $("#totalDetailsPaiementsDiv1").text(totalDiscounts1.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));

                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                                label: 'Montant Net',
                                data: netPayeData,
                                borderColor: 'rgb(3, 74, 252)',
                                backgroundColor: 'rgb(3, 74, 252)',
                            },
                            {
                                label: 'Montant Net service',
                                data: netPayeData1,
                                borderColor: 'rgb(202, 200, 164)',
                                backgroundColor: 'rgb(11, 93, 93 )',
                            },

                            {
                                label: 'details Paye',
                                data: details_paiements,
                                borderColor: 'rgb(65, 252, 3)',
                                backgroundColor: 'rgb(39, 199, 221 )',
                            },
                            {
                                label: 'details Paye service',
                                data: details_paiements1,
                                borderColor: 'rgb(65, 252, 3)',
                                backgroundColor: 'rgb(218, 13, 224 )',
                            },
                            {
                                label: 'Montant due ',
                                data: dueData,
                                borderColor: 'rgb(252, 3, 7)',
                                backgroundColor: 'rgb(252, 3, 7)',
                            },
                            {
                                label: 'Montant due service',
                                data: dueData1,
                                borderColor: 'rgb(252, 3, 7)',
                                backgroundColor: 'rgb(211, 84, 0  )',
                            },
                        ],
                    },
                    options: {

                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
                myChartSecond = new Chart(ctxSecond, {
                    type: 'doughnut',
                    data: {
                        labels: ['total', 'total_service', 'recu', 'recu_service', 'impayé', 'impayé_service', ],
                        datasets: [{
                            data: [totalNetPaye, totalNetPaye1, totalDetails, totalDetails1, totalDue, totalDue1],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: [
                                'rgb(3, 74, 252)',
                                'rgb(23, 43, 43 )',
                                'rgb(65, 252, 3)',
                                'rgb(33, 205, 25 )',
                                'rgb(252, 3, 7)',
                                'rgb(225, 160, 21 )',
                            ],
                            hoverOffset: 4
                        }, ],
                    }
                });

            });

        // Écoutez les changements dans la sélection d'année
        var yearSelect = document.getElementById('year');
        yearSelect.addEventListener('change', function() {
            updateChart(this.value);
        });
    }
    // Chargez initialement le graphique pour l'année actuelle
    var day = 'day'
    updateChart(day);
</script>
@endsection
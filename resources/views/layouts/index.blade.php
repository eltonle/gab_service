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
                        <p class="text-truncate font-size-14 mb-2">Total somme crédit</p>
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
                var transactions = data[0]; // Remplacez 'transactions' par le nom correct de la clé dans votre objet JSON
                var details = data[1]; // Remplacez 'transactions' par le nom correct de la clé dans votre objet JSON

                // Organisez les données par mois
                var months = Array.from({
                    length: 12
                }, (_, i) => i + 1);
                var payeData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.paid_amount, 0));
                var dueData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.due_amount, 0));
                var netPayeData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.total_amount, 0));
                var discounts = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.discount_amount, 0));
                var details_paiements = months.map(month => details.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.current_paid_amount, 0));

                var totalPaye = payeData.reduce((acc, cur) => acc + cur, 0);
                var totalDue = dueData.reduce((acc, cur) => acc + cur, 0);
                var totalNetPaye = netPayeData.reduce((acc, cur) => acc + cur, 0);
                var totalDiscounts = discounts.reduce((acc, cur) => acc + cur, 0);
                var totalDetails = details_paiements.reduce((acc, cur) => acc + cur, 0);
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
                $("#totalDueDiv").text(totalDue.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalNetPayeDiv").text(totalDetails.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalDetailsPaiementsDiv").text(totalDiscounts.toLocaleString('fr-FR', {
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
                                label: 'details Paye',
                                data: details_paiements,
                                borderColor: 'rgb(65, 252, 3)',
                                backgroundColor: 'rgb(65, 252, 3)',
                            },
                            {
                                label: 'Montant due ',
                                data: dueData,
                                borderColor: 'rgb(252, 3, 7)',
                                backgroundColor: 'rgb(252, 3, 7)',
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
                        labels: ['total', 'recu', 'impayé', ],
                        datasets: [{
                            data: [totalNetPaye, totalDetails, totalDue],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: [
                                'rgb(3, 74, 252)',
                                'rgb(65, 252, 3)',
                                'rgb(252, 3, 7)',
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

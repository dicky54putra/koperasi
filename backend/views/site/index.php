<?php

use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use backend\models\AktPenjualan;
use backend\models\DataPenjualanBarang;

/* @var $this yii\web\View */

if (Yii::$app->user->isGuest) {
    header("Location: index.php");
    exit;
}
$this->title = 'Dashboard';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/"><?= $this->title ?></a></li>
    </ul>
    <!-- label -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading panel-primary">
                    <h4 style="font-weight: bold;"> Data Penjualan Per Hari </h4>
                </div>
                <div class="panel-body">
                    <canvas id="chart-area" style="height:500px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/Chart.js"></script>
<script>
    const ctx = document.getElementById("chart-area").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [{
                data: [
                    <?php
                    foreach ($tanggal as $key => $value) {
                        $data_count = DataPenjualanBarang::find()->where(['tanggal_pembelian' => $value['tanggal_pembelian']])->count('id_pembelian');
                        foreach ($data_count as $key => $value) {
                            echo '"' . $value->tanggal_pembelian . '",';
                        }
                    }
                    // foreach ($tanggal as $t) {
                    // echo $t['tanggal_pembelian'];
                    // $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_pembelian) as pembelian FROM data_pembelian_barang WHERE tanggal_pembelian = '$t[tanggal_pembelian]'")->query();
                    // foreach ($data_count as $g) {
                    //     echo '"' . $g['tanggal_pembelian'] . '",';
                    // }
                    // }
                    ?>, '0'
                ],
                backgroundColor: 'green',
                borderColor: 'green',
                fill: false,
                lineTension: 0.5,
                label: 'Pembelian'
            }],
            labels: [
                <?php
                foreach ($tanggal_labels as $tgl) {
                    echo '"' . tanggal_indo($tgl['tanggal_pembelian']) . '",';
                }
                ?>
            ]
        },
        options: {
            segmentShowStroke: true,
            segmentStrokeColor: '#fff',
            segmentStrokeWidth: 1,
            percentageInnerCutout: 0,
            animationSteps: 100,
            animationEasing: 'easeOutBounce',
            animateRotate: true,
            animateScale: false,
            responsive: true,
            maintainAspectRatio: false,
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            legend: {
                display: true,
                position: 'bottom',
                fontSize: 10,
                boxWidth: 20
            },
            title: {
                display: false,
            },
            chartArea: {
                backgroundColor: 'rgba(255, 255, 255, 1)'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return 'Jumlah : ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                },
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 10
                    }
                }]
            }
        }
    });
</script>
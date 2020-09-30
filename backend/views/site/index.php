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
    <div class="row">
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Rp. <?php //pretty_money_minus($sum_omzet) 
                            ?> </h3>
                    <p>Total Omzet</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Rp.<?php //pretty_money_minus($saldo_kas->saldo_akun) 
                            ?> </h3>
                    <p>Total Kas</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Rp. <?php //pretty_money_minus($saldo_piutang) 
                            ?> </h3>
                    <p>Total Piutang</p>
                </div>
                <div class="icon">
                    <i class="fa fa-funnel-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Rp. <?php //pretty_money_minus($saldo_hutang) 
                            ?> </h3>
                    <p>Total Hutang</p>
                </div>
                <div class="icon">
                    <i class="fa fa-funnel-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    </div>
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
        type: 'line',
        data: {
            datasets: [{
                    data: [
                        <?php
                        foreach ($tanggal as $t) {
                            $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_penjualan_detail) as penjualan FROM data_penjualan_detail LEFT JOIN data_penjualan_barang ON data_penjualan_barang.id_penjualan = data_penjualan_detail.id_penjualan WHERE tanggal_penjualan = '$t[tanggal_penjualan]'")->query();
                            foreach ($data_count as $g) {
                                if (!empty($g['penjualan'])) {
                                    echo '"' . $g['penjualan'] . '",';
                                } else {
                                    echo '0';
                                }
                            }
                        }
                        ?>, '0'
                    ],
                    backgroundColor: 'green',
                    borderColor: 'green',
                    fill: false,
                    lineTension: 0,
                    // lineTension: 0.5,
                    label: ['Pembelian']
                },
                {
                    data: ['0',
                        <?php
                        foreach ($tanggal2 as $t) {
                            $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_pembelian_detail) as pembelian FROM data_pembelian_detail LEFT JOIN data_pembelian_barang ON data_pembelian_barang.id_pembelian = data_pembelian_detail.id_pembelian WHERE data_pembelian_barang.tanggal_pembelian = '$t[tanggal_pembelian]'")->query();
                            foreach ($data_count as $g) {
                                if (!empty($g['pembelian'])) {
                                    echo '"' . $g['pembelian'] . '",';
                                } else {
                                    echo '0';
                                }
                            }
                        }
                        ?>, '0'
                    ],
                    backgroundColor: 'red',
                    borderColor: 'red',
                    fill: false,
                    lineTension: 0,
                    // lineTension: 0.5,
                    label: ['Penjualan']
                },
            ],
            labels: [
                <?php
                // $day = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
                // $bln = tanggal_indo(date('Y') . '-' . date('m') . '-');
                // // $thn = date('Y');
                // foreach ($day as $tgl) {
                //     echo '"' . $tgl . $bln . '",';
                // }

                foreach ($tanggal_label as $tgl) {
                    echo '"' . tanggal_indo($tgl['tanggal_penjualan']) . '",';
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
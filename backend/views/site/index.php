<?php

use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use backend\models\AktPenjualan;
use backend\models\DataPembelianDetail;
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
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Rp. <?= pretty_money_minus($omzet)
                            ?> </h3>
                    <p>Total Omzet</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Rp. <?= pretty_money_minus($kas)
                            ?> </h3>
                    <p>Total Kas</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Rp. <?= pretty_money_minus($piutang)
                            ?> </h3>
                    <p>Total Piutang</p>
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
                    <h4 style="font-weight: bold;"> Data Penjualan Dan Pembelian Per Hari </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="chart-area2" style="height:350px;"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart-area" style="height:350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- labarugi -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading panel-primary">
                    <h4 style="font-weight: bold;"><a style="color: white;" href="index.php?r=laporan/laporan-laba-rugi">Data Laba/Rugi Per Hari <?= tanggal_indo(date('Y-m-d')) ?></a></h4>
                </div>
                <div class="panel-body">
                    <table class="table" id="table-index">
                        <tbody>
                            <?php $tanggal_hari_ini = date('Y-m-d'); ?>
                            <tr>
                                <th>Pendapatan</th>
                                <th></th>
                                <th>Pengeluaran</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>Pejualan Cash</td>
                                <td align="right">
                                    <?php
                                    $pendapatan_cash =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 1 AND data_penjualan_barang.tanggal_penjualan = '$tanggal_hari_ini'")->queryScalar();
                                    echo ribuan($pendapatan_cash);
                                    ?>
                                </td>
                                <td>Pembelian</td>
                                <td align="right">
                                    <?php
                                    $pembelian =  Yii::$app->db->createCommand("SELECT SUM(total_beli) FROM data_pembelian_detail  INNER JOIN data_pembelian_barang ON data_pembelian_detail.id_pembelian = data_pembelian_barang.id_pembelian WHERE data_pembelian_barang.tanggal_pembelian = '$tanggal_hari_ini'")->queryScalar();
                                    echo ribuan($pembelian);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Pejualan Kredit</td>
                                <td align="right">
                                    <?php
                                    $pendapatan_kredit =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 2 AND data_penjualan_barang.tanggal_penjualan = '$tanggal_hari_ini'")->queryScalar();
                                    echo ribuan($pendapatan_kredit);
                                    ?>
                                </td>
                                <td>Pinjaman</td>
                                <td align="right">
                                    <?php
                                    $pinjam =  Yii::$app->db->createCommand("SELECT SUM(nominal) FROM simpan_pinjam WHERE jenis = 2 AND tanggal = '$tanggal_hari_ini'")->queryScalar();
                                    echo ribuan($pinjam);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Simpan</td>
                                <td align="right">
                                    <?php
                                    $simpan =  Yii::$app->db->createCommand("SELECT SUM(nominal) FROM simpan_pinjam WHERE jenis = 1 AND tanggal = '$tanggal_hari_ini'")->queryScalar();
                                    echo ribuan($simpan);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Pendapatan</th>
                                <th style="border-top: 1px solid #000000; float: right;">
                                    <?php
                                    $total_pendapatan = $simpan + $pendapatan_cash + $pendapatan_kredit;
                                    echo ribuan($total_pendapatan);
                                    ?>
                                </th>
                                <th>Total Pengeluaran</th>
                                <th style="border-top: 1px solid #000000;float: right;">
                                    <?php
                                    $total_pengeluaran = $pinjam + $pembelian;
                                    echo ribuan($total_pengeluaran);
                                    ?>
                                </th>
                            </tr>
                            <tr style="border-top: 1px solid #000000;">
                                <th style="border-top: 1px solid #000000;">Laba/Rugi</th>
                                <th style="border-top: 1px solid #000000;"></th>
                                <th style="border-top: 1px solid #000000;"></th>
                                <th style="border-top: 1px solid #000000;">
                                    <p style="float: right;">
                                        <?php
                                        $laba_rugi = $total_pendapatan - $total_pengeluaran;
                                        echo ribuan($laba_rugi);
                                        ?>
                                    </p>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/Chart.js"></script>
<script>
    const ctx = document.getElementById("chart-area").getContext('2d');
    const ctx2 = document.getElementById("chart-area2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
                foreach ($tanggal_label as $tgl) {
                    echo '"' . tanggal_indo($tgl['tanggal_penjualan']) . '",';
                }
                ?>
            ],
            datasets: [{
                data: [
                    <?php
                    foreach ($tanggal as $t) {
                        $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_penjualan) as penjualan FROM data_penjualan_barang WHERE tanggal_penjualan = '$t[tanggal_penjualan]'")->query();
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
                backgroundColor: 'red',
                borderColor: 'red',
                fill: false,
                lineTension: 0,
                // lineTension: 0.5,
                label: ['Penjualan']
            }, ],
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
                display: true,
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
    var myChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: [
                <?php
                foreach ($tanggal_label2 as $tgl) {
                    echo '"' . tanggal_indo($tgl['tanggal_pembelian']) . '",';
                }
                ?>
            ],
            datasets: [{
                data: [
                    <?php
                    foreach ($tanggal2 as $t) {
                        $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_pembelian) as pembelian FROM data_pembelian_barang WHERE tanggal_pembelian = '$t[tanggal_pembelian]'")->query();
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
                backgroundColor: 'green',
                borderColor: 'green',
                fill: false,
                lineTension: 0,
                // lineTension: 0.5,
                label: ['Pembelian']
            }, ],
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
                display: true,
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
<?php

use backend\models\DataBarang;
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\models\DataPenjualanDetail;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Laba Rugi';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box">
        <div class="box-header">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?= Html::beginForm(['laporan-laba-rugi', array('class' => 'form-inline')]) ?>

                    <table border="0" width="100%">
                        <tr>
                            <td width="10%">
                                <div class="form-group">Dari Tanggal</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <input type="date" name="tanggal_awal" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : '' ?>" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">
                                <div class="form-group">Sampai Tanggal</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <input type="date" name="tanggal_akhir" value="<?= (!empty($tanggal_akhir)) ? $tanggal_akhir : '' ?>" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="form-group">
                                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                    <?php
                                    if ($tanggal_awal != 0 && $tanggal_akhir != 0) {
                                        # code...
                                    ?>
                                        <?= Html::a('Export Laporan', ['export-excel-laporan-laba-rugi', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-info" style="overflow: auto">
        <div class="col-md-12" style="padding: 0;">
            <div class="box-body">
                <p style="font-family: 'Times New Roman'">
                    <h4>Periode : <?= ($tanggal_awal != '') ? date('d/m/Y', strtotime($tanggal_awal)) : '-'; ?> Sampai <?= ($tanggal_akhir != '') ? date('d/m/Y', strtotime($tanggal_akhir)) : '-'; ?></h4>
                </p>

                <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)) { ?>
                    <table class="table" id="table-index">
                        <tbody>
                            <tr>
                                <th colspan="2">Pendapatan</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>Pejualan Cash</td>
                                <td align="right">
                                    <?php
                                    $pendapatan_cash =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 1 AND data_penjualan_barang.tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                                    echo ribuan($pendapatan_cash);
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pejualan Kredit</td>
                                <td align="right">
                                    <?php
                                    $pendapatan_kredit =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 2 AND data_penjualan_barang.tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                                    echo ribuan($pendapatan_kredit);
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Barang Titipan</td>
                                <td align="right">
                                    <?php
                                    $titipan =  Yii::$app->db->createCommand("SELECT * FROM stok_titipan WHERE  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
                                    $jual = 0;
                                    $beli = 0;
                                    foreach ($titipan as $key => $value) {
                                        $barang = DataBarang::find()->where(['id_barang' => $value['id_barang']])->one();
                                        $beli += $barang->harga_beli * $value['qty'];
                                        $jual += $barang->harga_jual * $value['qty'];
                                        // echo $barang->harga_jual . '-' . $barang->harga_beli . '-' . $value['qty'] . '<br>';
                                    }
                                    $jumlah_titipan = $jual - $beli;
                                    echo ribuan($jumlah_titipan);
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="2">Total Pendapatan</th>
                                <th style="border-top: 1px solid #000000;">
                                    <p style="float: right;">
                                        <?php
                                        $total_pendapatan = $jumlah_titipan + $pendapatan_cash + $pendapatan_kredit;
                                        echo ribuan($total_pendapatan);
                                        ?>
                                    </p>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">Pengeluaran</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>Pembelian</td>
                                <td align="right">
                                    <?php
                                    $pembelian =  Yii::$app->db->createCommand("SELECT SUM(total_beli) FROM data_pembelian_detail  INNER JOIN data_pembelian_barang ON data_pembelian_detail.id_pembelian = data_pembelian_barang.id_pembelian WHERE data_pembelian_barang.tanggal_pembelian BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                                    echo ribuan($pembelian);
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="2">Total Pengeluaran</th>
                                <th style="border-top: 1px solid #000000;">
                                    <p style="float: right;">
                                        <?php
                                        $total_pengeluaran = $pembelian;
                                        echo ribuan($total_pengeluaran);
                                        ?>
                                    </p>
                                </th>
                            </tr>
                            <tr style="border-top: 1px solid #000000;">
                                <th style="border-top: 1px solid #000000;" colspan="2">Laba/Rugi</th>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>
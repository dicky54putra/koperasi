<?php

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

$this->title = 'Laporan Pinjaman Toko';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-view">

    <h4><?= Html::encode($this->title) ?></h4>

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
                                    <input type="date" name="tanggal_awal" class="form-control" required>
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
                                    <input type="date" name="tanggal_akhir" class="form-control" required>
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
                                <th>Pendapatan</th>
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
                            </tr>
                            <tr>
                                <td>Pejualan Kredit</td>
                                <td align="right">
                                    <?php
                                    $pendapatan_kredit =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 2 AND data_penjualan_barang.tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                                    echo ribuan($pendapatan_kredit);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Simpan</td>
                                <td align="right">
                                    <?php
                                    $simpan =  Yii::$app->db->createCommand("SELECT SUM(nominal) FROM simpan_pinjam WHERE jenis = 1 AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
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
                            </tr>
                            <tr>
                                <th>Pengeluaran</th>
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
                            </tr>
                            <tr>
                                <td>Pinjaman</td>
                                <td align="right">
                                    <?php
                                    $pinjam =  Yii::$app->db->createCommand("SELECT SUM(nominal) FROM simpan_pinjam WHERE jenis = 2 AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                                    echo ribuan($pinjam);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Pengeluaran</th>
                                <th style="border-top: 1px solid #000000;float: right;">
                                    <?php
                                    $total_pengeluaran = $pinjam + $pembelian;
                                    echo ribuan($total_pengeluaran);
                                    ?>
                                </th>
                            </tr>
                            <tr style="border-top: 1px solid #000000;">
                                <th>Laba/Rugi</th>
                                <th style="float: right;">
                                    <?php
                                    $laba_rugi = $total_pendapatan - $total_pengeluaran;
                                    echo ribuan($laba_rugi);
                                    ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
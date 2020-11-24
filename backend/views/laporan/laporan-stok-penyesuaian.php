<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\models\StokMasuk;
use backend\models\StokKeluar;
use backend\models\DataPembelianDetail;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Stok Barang';
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
                    <?= Html::beginForm(['laporan-stok-penyesuaian', array('class' => 'form-inline')]) ?>

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
                                        <?= Html::a('Export Laporan', ['export-excel-laporan-stok-penyesuaian', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
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
                    <h4>Periode Bulan: <?= ($tanggal_awal != '') ? tanggal_indo2(date('F', strtotime($tanggal_awal))) : '-'; ?></h4>
                </p>

                <table class="table" id="table-index">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Tanggal, Qty, & Keterangan</th>
                            <th>Stok Sekarang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $totalan_pengurangan = 0;
                        $tgl_masuk = '';
                        $tgl_keluar = '';
                        $qty_masuk = 0;
                        $qty_keluar = 0;
                        $query1 = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM stok_penyesuaian
                                        LEFT JOIN data_barang ON data_barang.id_barang = stok_penyesuaian.id_barang
                                        GROUP BY data_barang.id_barang
                                        ORDER BY data_barang.id_barang
                                        ")->query();
                        foreach ($query1 as $key => $data) {
                            $total_stok = 0;
                            $total_stok_kosong = '';
                            if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                                $stok_penyesuaian = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM stok_penyesuaian
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryAll();
                            }
                        ?>
                            <tr>
                                <td><?= $no++ . '.' ?></td>
                                <td><?= $data['nama_barang'] ?></td>
                                <td>
                                    <table style="width: 100%;">
                                        <?php
                                        if (!empty($stok_penyesuaian)) {
                                            foreach ($stok_penyesuaian as $key => $val) {
                                        ?>
                                                <tr>
                                                    <td style="width: 35%;"><?= (!empty($val['tanggal'])) ? tanggal_indo($val['tanggal']) . ',' : ''; ?></td>
                                                    <td style="width: 15%;"><?= ($val['tipe'] == 1) ? $val['qty'] . ',' : '(' . $val['qty'] . '),'; ?></td>
                                                    <td><?= ($val['tipe'] == 1) ? ', ' . number_format($val['qty'] * $data['harga_jual']) : ', (' . number_format($val['qty'] * $data['harga_jual']) . ')'; ?></td>
                                                    <!-- $val['keterangan'] -->
                                                </tr>
                                            <?php  } ?>
                                        <?php  } ?>
                                    </table>
                                </td>
                                <td><?= $data['stok'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
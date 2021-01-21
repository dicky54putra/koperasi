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

$this->title = 'Laporan Stok Titipan';
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
                    <?= Html::beginForm(['laporan-stok-titipan', array('class' => 'form-inline')]) ?>

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
                                        <?= Html::a('Export Laporan', ['export-excel-laporan-stok-titipan', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
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
                            <th>Laku</th>
                            <th>Stok Sekarang</th>
                        </tr>
                    </thead>
                    <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)) { ?>
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
                                        FROM stok_titipan
                                        LEFT JOIN data_barang ON data_barang.id_barang = stok_titipan.id_barang
                                        WHERE data_barang.tipe = 1
                                        AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        GROUP BY data_barang.id_barang
                                        ORDER BY data_barang.id_barang
                                        ")->query();
                            foreach ($query1 as $key => $data) {
                                $total_stok = 0;
                                $total_stok_kosong = '';
                                if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                                    $stok_titipan = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM stok_titipan
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
                                            $sum_diambil = 0;
                                            $sum_setor = 0;
                                            if (!empty($stok_titipan)) {
                                                foreach ($stok_titipan as $key => $val) {
                                                    if ($val['keterangan'] == 'diambil') {
                                                        $jum_diambil = $val['qty'] * $data['harga_jual'];
                                                        $sum_diambil += $jum_diambil;
                                                        $jum_setor = 0;
                                                        $sum_setor = 0;
                                                    } else {
                                                        $jum_diambil = 0;
                                                        $sum_diambil = 0;
                                                        $jum_setor = $val['qty'] * $data['harga_jual'];
                                                        $sum_setor += $jum_setor;
                                                    }

                                            ?>
                                                    <tr>
                                                        <td style="width: 35%;"><?= (!empty($val['tanggal'])) ? tanggal_indo($val['tanggal']) . ',' : ''; ?></td>
                                                        <td style="width: 15%;"><?= $val['qty']; ?></td>
                                                        <td>
                                                            <?= ($jum_diambil > 0) ? number_format($jum_diambil) : number_format($jum_setor); ?>
                                                        </td>
                                                        <td align="right"><?= $val['keterangan'] ?></td>
                                                    </tr>
                                                    <?php

                                                    ?>
                                                <?php  } ?>
                                            <?php  } ?>
                                        </table>
                                    </td>
                                    <td>
                                        <?php
                                        $diambil = Yii::$app->db->createCommand("SELECT * FROM stok_titipan LEFT JOIN data_barang ON data_barang.id_barang = stok_titipan.id_barang WHERE data_barang.tipe = 1 AND stok_titipan.keterangan = 'diambil' AND stok_titipan.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND data_barang.id_barang = $data[id_barang]")->queryAll();

                                        $setor = Yii::$app->db->createCommand("SELECT * FROM stok_titipan LEFT JOIN data_barang ON data_barang.id_barang = stok_titipan.id_barang WHERE data_barang.tipe = 1 AND stok_titipan.keterangan != 'diambil' AND stok_titipan.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND data_barang.id_barang = $data[id_barang]")->queryAll();

                                        $sum = 0;
                                        $sum_ = 0;
                                        $stok = 0;
                                        $stok_ = 0;
                                        foreach ($diambil as $key => $value) {
                                            $jum = $value['qty'] * $value['harga_jual'];
                                            $sum += $jum;
                                            $stok += $value['qty'];
                                        }
                                        foreach ($setor as $key => $value) {
                                            $jum_ = $value['qty'] * $value['harga_jual'];
                                            $stok_ += $value['qty'];
                                            $sum_ += $jum_;
                                        }
                                        echo $h_stok =  $stok_ - $stok;

                                        ?>
                                    </td>
                                    <td><?= $data['stok'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
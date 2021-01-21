<?php

use backend\models\DataPembelianDetail;
use backend\models\DataPenjualanBarang;
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

$this->title = 'Laporan Pembelian';
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
                    <?= Html::beginForm(['laporan-pembelian', array('class' => 'form-inline')]) ?>

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
                                        <?= Html::a('Export Laporan', ['export-excel-laporan-pembelian', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
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

                <table class="table" id="table-index">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pembelian</th>
                            <th>Supplier</th>
                            <th>No. faktur</th>
                            <th>Detail Barang (qty x harga satuan)</th>
                            <th>Harga Total</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $totalan_pengurangan = 0;
                        $grandtotal_ = 0;
                        $barang = '';
                        $hrg_barang = '';
                        $diskon = '';
                        $ppn = '';
                        $query1 = Yii::$app->db->createCommand("
                                        SELECT data_pembelian_barang.id_pembelian, data_pembelian_barang.id_anggota, data_pembelian_barang.no_faktur, data_pembelian_barang.tanggal_pembelian, data_pembelian_barang.grandtotal, anggota_koperasi.nama_anggota
                                        FROM data_pembelian_detail
                                        LEFT JOIN data_pembelian_barang ON data_pembelian_barang.id_pembelian = data_pembelian_detail.id_pembelian
                                        LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = data_pembelian_barang.id_anggota
                                        WHERE data_pembelian_barang.tanggal_pembelian
                                        BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        GROUP BY data_pembelian_detail.id_pembelian
                                        ORDER BY data_pembelian_barang.tanggal_pembelian
                                        ")->query();
                        foreach ($query1 as $key => $data) {
                            $detail = DataPembelianDetail::find()->where(['id_pembelian' => $data['id_pembelian']])->all();
                        ?>
                            <tr>
                                <td><?= $no++ . '.' ?></td>
                                <td><?= tanggal_indo($data['tanggal_pembelian'], true) ?></td>
                                <td><?= (!empty($data['nama_anggota'])) ? $data['nama_anggota'] : 'Supplier tidak ditentukan'; ?></td>
                                <td><?= (!empty($data['no_faktur'])) ? $data['no_faktur'] : 'No faktur tidak ditentukan'; ?></td>
                                <td>
                                    <?php
                                    foreach ($detail as $key => $value) {
                                        echo $barang = (!empty($value->barang->nama_barang)) ? $value->barang->nama_barang . ' ( ' . $value->qty . ' x ' . $value->harga_beli . ' ) <br>' : 'Barang tidak ada/ sudah dihapus'  . "<br>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $grandtotal = 0;
                                    foreach ($detail as $key => $value) {
                                        $hrg_barang = $value->total_beli;
                                        echo number_format($value->total_beli) . '<br>';
                                        $grandtotal += $hrg_barang;
                                    }
                                    ?>
                                </td>
                                <td><?= number_format($grandtotal) ?></td>
                            </tr>
                            <?php
                            $grandtotal_ += $grandtotal;
                            ?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6"><b>GRANDTOTAL</b></td>
                            <td><?= number_format($grandtotal_) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
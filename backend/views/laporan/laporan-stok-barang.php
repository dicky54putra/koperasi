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
use backend\models\StokPenyesuaian;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Stok Barang';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <div class="box">
        <div class="box-header">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?= Html::beginForm(['laporan-stok-barang', array('class' => 'form-inline')]) ?>

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
                                        <?= Html::a('Export Laporan', ['export-excel-laporan-stok-barang', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
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
            <div class="box-body" style="overflow: auto;">
                <p style="font-family: 'Times New Roman'">
                    <h4>Periode Bulan: <?= ($tanggal_awal != '') ? tanggal_indo2(date('F', strtotime($tanggal_awal))) : '-'; ?></h4>
                </p>

                <table class="table table-bordered" id="table-index">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kode Barang</th>
                            <th rowspan="2">Nama Barang</th>
                            <th rowspan="2">Harga Beli</th>
                            <th rowspan="2">Harga Jual</th>
                            <th colspan="2" style="white-space: nowrap;">Persediaan Awal</th>
                            <th colspan="2" style="white-space: nowrap;">Penjualan</th>
                            <th colspan="2" style="white-space: nowrap;">Barang Masuk</th>
                            <th colspan="2" style="white-space: nowrap;">Persediaan Akhir</th>
                            <th colspan="2" style="white-space: nowrap;">Persediaan Dikoperasi</th>
                            <th colspan="2" style="white-space: nowrap;">Selisih Kurang/Lebih</th>
                            <th rowspan="2">Keterangan</th>
                            <!-- <th>Margin (Stok Masuk - Stok Keluar)</th> -->
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Qty</th>
                            <th>Nominal</th>
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
                        // SELECT data_barang.id_barang, data_barang.kode_barang, data_barang.nama_barang, kategori_barang.nama_kategori, data_barang.harga_jual, data_barang.harga_beli, data_barang.stok
                        $query1 = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM data_barang
                                        LEFT JOIN data_satuan ON data_satuan.id_satuan = data_barang.id_satuan
                                        LEFT JOIN kategori_barang ON kategori_barang.id_kategori = data_barang.id_kategori
                                        ORDER BY data_barang.id_barang
                                        ")->query();
                        foreach ($query1 as $key => $data) {
                            $total_stok = 0;
                            $total_stok_kosong = '';
                            $stok_masuk = Yii::$app->db->createCommand("
                                        SELECT total_qty
                                        FROM stok_masuk
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_masuk BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryScalar();
                            $stok_keluar = Yii::$app->db->createCommand("
                                        SELECT total_qty
                                        FROM stok_keluar
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryScalar();
                        ?>
                            <tr>
                                <td><?= $no++ . '.' ?></td>
                                <td><?= $data['kode_barang'] ?></td>
                                <td><?= $data['nama_barang'] ?></td>
                                <td><?= number_format($data['harga_beli']) ?></td>
                                <td><?= number_format($data['harga_jual']) ?></td>
                                <?php
                                $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->all();
                                $jml = 0;
                                $jml_ = 0;
                                foreach ($stok_penyesuaian as $key => $val) {
                                    if ($val->tipe == 1) {
                                        $jml += $val['qty'];
                                        // $qty = $val['qty'] . '<br>';
                                    } else {
                                        $jml_ += $val['qty'];
                                        // $qty = '(' . $val['qty'] . ')<br>';
                                    }
                                }
                                // if ($jml_ > $jml) {
                                $jmll = $jml_ - $jml;
                                // } else {
                                //     $jmll = $jml - $jml_;
                                // }
                                // echo '<b>' . $jmll . '</b>';
                                ?>
                                <td>
                                    <!-- qty persediaan awal -->
                                    <?php
                                    $stok_awal = $data['stok'] + $jmll + $stok_keluar - $stok_masuk;
                                    echo $stok_awal;
                                    ?>
                                </td>
                                <td>
                                    <!-- nominal persediaan awal -->
                                    <?= number_format($stok_awal *  $data['harga_beli']) ?>
                                </td>
                                <td>
                                    <!-- qty persediaan penjualan -->
                                    <?= (!empty($stok_keluar)) ? $stok_keluar : '-' ?>
                                </td>
                                <td>
                                    <!-- nominal persediaan penjualan -->
                                    <?= number_format($stok_keluar * $data['harga_jual']) ?>
                                </td>
                                <td>
                                    <!-- qty persediaan barang masuk -->
                                    <?= (!empty($stok_masuk)) ? $stok_masuk : '-' ?>
                                </td>
                                <td>
                                    <!-- nominal persediaan barang masuk -->
                                    <?= number_format($stok_masuk * $data['harga_beli']) ?>
                                </td>
                                <td>
                                    <!-- qty persediaan akhir -->
                                    <?php
                                    $p_akhir = $stok_awal + $stok_masuk - $stok_keluar;
                                    echo $p_akhir;
                                    ?>
                                </td>
                                <td>
                                    <!-- nominal persediaan akhir -->
                                    <?= number_format($p_akhir * $data['harga_beli']) ?>
                                </td>
                                <td>
                                    <!-- qty persediaan gudang -->
                                    <?= $data['stok'] ?>
                                </td>
                                <td>
                                    <?= number_format($data['stok'] * $data['harga_beli']) ?>
                                    <!-- nominal persediaan gudang -->
                                </td>
                                <td>
                                    <?php
                                    $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->all();
                                    $jml = 0;
                                    $jml_ = 0;
                                    foreach ($stok_penyesuaian as $key => $val) {
                                        if ($val->tipe == 1) {
                                            $jml += $val['qty'];
                                            echo (!empty($val['qty'])) ? $val['qty'] . '<br>' : '-';
                                        } else {
                                            $jml_ += $val['qty'];
                                            echo (!empty($val['qty'])) ? $val['qty'] . '<br>' : '-';
                                        }
                                    }
                                    // if ($jml_ > $jml) {
                                    //     $jmll = $jml_ - $jml;
                                    // } else {
                                    $jmll = $jml - $jml_;
                                    // }
                                    // echo '<b>' . $jmll . '</b>';
                                    ?>
                                    <!-- qty persediaan penyesuaian -->
                                </td>
                                <td>
                                    <?php
                                    $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->all();
                                    foreach ($stok_penyesuaian as $key => $val) {
                                        if ($val->tipe == 1) {
                                            echo number_format($val['qty'] *  $data['harga_jual']) . '<br>';
                                        } else {
                                            echo '(' . number_format($val['qty'] *  $data['harga_jual']) . ')<br>';
                                        }
                                    }
                                    ?>
                                    <!-- nominal persediaan penyesuaian -->
                                </td>
                                <td>
                                    <?php
                                    $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->all();
                                    foreach ($stok_penyesuaian as $key => $val) {
                                        echo $val['keterangan'] . '<br>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
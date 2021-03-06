<?php

use backend\models\AnggotaKoperasi;
use yii\helpers\Html;
use backend\models\DataPenjualanDetail;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Penjualan';
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
                    <?= Html::beginForm(['laporan-penjualan', array('class' => 'form-inline')]) ?>

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
                                    <input type="date" name="tanggal_awal" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))) ?>" class="form-control" required>
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
                                    <input type="date" name="tanggal_akhir" value="<?= (!empty($tanggal_akhir)) ? $tanggal_akhir : date('Y-m-d') ?>" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">
                                <div class="form-group">Anggota</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <?= Select2::widget([
                                        // 'model' => $model,
                                        'name' => 'id_anggota',
                                        'value' => $id_anggota,
                                        'data' => ArrayHelper::map(AnggotaKoperasi::find()->all(), 'id_anggota', function ($model) {
                                            return 'Nama Anggota: ' . $model->nama_anggota;
                                        }),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Pilih Anggota'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">
                                <div class="form-group">Jenis Pembayaran</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <?= Select2::widget([
                                        // 'model' => $model,
                                        'name' => 'jenis_pembayaran',
                                        'value' => $jenis_pembayaran,
                                        'data' => [
                                            2 => 'Tagihan',
                                            1 => 'Lunas'
                                        ],
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Pilih Jenis Pembayaran'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ]);
                                    ?>
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
                                        <?= Html::a('Export Laporan', ['export-excel-laporan-penjualan', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'id_anggota' => $id_anggota, 'jenis_pembayaran' => $jenis_pembayaran], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
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
                            <th>Tanggal Penjualan</th>
                            <th>Nama Anggota</th>
                            <th>No. Invoice</th>
                            <th>Detail Barang (qty x harga satuan)</th>
                            <th>Diskon</th>
                            <th>Pajak</th>
                            <th>Harga Total</th>
                            <th>Status Pembayaran</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $totalan_pengurangan = 0;
                        $gt_penjualan = 0;
                        $barang = '';
                        $hrg_barang = '';
                        $diskon = '';
                        $ppn = '';
                        $where_anggota = (!empty($id_anggota)) ? "AND data_penjualan_barang.id_anggota = $id_anggota" : null;
                        $where_pembayaran = (!empty($jenis_pembayaran)) ? "AND data_penjualan_barang.jenis_pembayaran = $jenis_pembayaran" : null;
                        $query1 = Yii::$app->db->createCommand("SELECT data_penjualan_barang.id_penjualan, data_penjualan_barang.id_anggota, data_penjualan_barang.no_invoice, data_penjualan_barang.tanggal_penjualan, data_penjualan_barang.grandtotal, data_penjualan_barang.jenis_pembayaran, anggota_koperasi.nama_anggota
                                        FROM data_penjualan_barang
                                        LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = data_penjualan_barang.id_anggota
                                        WHERE data_penjualan_barang.tanggal_penjualan
                                        BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        AND data_penjualan_barang.jenis_pembayaran in(1,2)
                                        $where_anggota
                                        $where_pembayaran
                                        ORDER BY data_penjualan_barang.tanggal_penjualan
                                        ")->query();
                        foreach ($query1 as $key => $data) {
                            $detail = DataPenjualanDetail::find()->where(['id_penjualan' => $data['id_penjualan']])->all();
                        ?>
                            <tr>
                                <td><?= $no++ . '.' ?></td>
                                <td><?= tanggal_indo($data['tanggal_penjualan'], true) ?></td>
                                <td><?= $data['nama_anggota'] ?></td>
                                <td><?= $data['no_invoice'] ?></td>
                                <td>
                                    <?php
                                    foreach ($detail as $key => $value) {
                                        echo $barang = (!empty($value->barang->nama_barang)) ? $value->barang->nama_barang : 'Barang tidak ada/ sudah dihapus' . ' ( ' . $value->qty . ' x ' . $value->harga_jual . ' ) ' . "<br>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($detail as $key => $value) {
                                        $diskon = $value->diskon;
                                        $diskon == 0 ? ' - <br>' : $diskon . '<br>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($detail as $key => $value) {
                                        $ppn = $value->ppn;
                                        echo $ppn == 0 ? ' - <br>' : $ppn . '<br>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $grandtotal = 0;
                                    foreach ($detail as $key => $value) {
                                        $hrg_barang = $value->total_jual;
                                        echo ribuan($value->total_jual) . '<br>';
                                        $grandtotal += $hrg_barang;
                                    }
                                    ?>
                                </td>
                                <td><?= $data['jenis_pembayaran'] == 1 ? 'LUNAS' : $retVal = ($data['jenis_pembayaran'] == 2) ? 'TAGIHAN' : 'Belum dikonfirmasi'; ?></td>
                                <td><?= ribuan($grandtotal) ?></td>
                            </tr>
                            <?php
                            $gt_penjualan += $grandtotal;
                            ?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="9">GRANDTOTAL</th>
                            <th><?= ribuan($gt_penjualan) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
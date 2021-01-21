<?php

use backend\models\DataBarang;
use backend\models\DataPenjualanDetail;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model backend\models\AnggotaKoperasi */

$this->title = 'Detail Anggota : ' . $model->nama_anggota;
$this->params['breadcrumbs'][] = ['label' => 'Anggota Koperasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="anggota-koperasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Anggota', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::button(
            '<span class="glyphicon glyphicon-edit"></span> Ubah',
            [
                'value' => Url::to(['update', 'id' => $model->id_anggota]),
                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-primary'
            ]
        ); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_anggota], [
            'class' => 'tombol-hapus btn btn-danger',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Print Karu Anggota', ['print-kartu', 'id' => $model->id_anggota], ['class' => 'btn btn-default text-blue', 'target' => '_BLANK']) ?>
    </p>

    <div class="box box-warning">
        <div class="box-body">
            <div class="col-md-12" style="padding: 0;">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'nama_anggota',
                        [
                            'attribute' => 'kode_anggota',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return yii\helpers\Html::tag('div', '', ['id' => 'barcode-' . $model->kode_anggota]) .
                                    \barcode\barcode\BarcodeGenerator::widget([
                                        'elementId' => 'barcode-' . $model->kode_anggota,
                                        'value' => $model->kode_anggota,
                                        'type' => 'ean13',
                                    ]);
                            },
                        ],
                        'alamat_anggota',
                        'kota',
                        'telp',
                        'npwp',
                        [
                            'attribute' => 'id_jenis_anggota',
                            'label' => 'Jenis Anggota',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->id_jenis_anggota == 1) {
                                    return 'Customer';
                                } else {
                                    return 'Supplier';
                                }
                            }
                        ],
                        'pangkat.nama_pangkat',
                        [
                            'attribute' => 'tanggal_keanggotaan',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return tanggal_indo($model->tanggal_keanggotaan);
                            }
                        ],
                        [
                            'attribute' => 'is_active',
                            'label' => 'Status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->is_active == 1) {
                                    return '<label class="label label-success">Aktif</label>';
                                } else {
                                    return '<label class="label label-danger">Tidak Aktif</label>';
                                }
                            }
                        ]
                    ],
                ]) ?>
            </div>

            <div class="col-md-12" style="margin-top:20px;">
                <ul class="nav nav-tabs" id="tabForRefreshPage">
                    <li class="active"><a data-toggle="tab" href="#history-pembelian"><span class="fa fa-truck-loading"></span> History Pembelian</a></li>
                    <li><a data-toggle="tab" href="#tagihan"><span class="fa fa-truck-loading"></span> Tagihan</a></li>
                </ul>
                <div class="tab-content">
                    <div id="history-pembelian" class="tab-pane fade in active" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <?php
                                $i = 0;
                                $grandtotal = 0;
                                foreach ($pembelian_history as $key => $value) {
                                    $i++;
                                    // $grandtotal += $value->total_beli;
                                ?>
                                    <div class="panel">
                                        <div class="panel-heading" role="tab" id="heading<?= $i; ?>">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsemasuk<?php echo $i; ?>" aria-expanded="true" aria-controls="collapsemasuk<?= $i; ?>" class="drop">
                                                <button class="form-control" style="border:none; background: rgba(0, 0, 0, 0.1); border-radius: 30px;">
                                                    <?php
                                                    $jenis = ($value->jenis_pembayaran == 1) ? '<label class="label label-warning">Lunas</label>' : $retVal = ($value->jenis_pembayaran == 2) ? '<label class="label label-danger">Tagihan</label>' : '<label class="label label-info">Belum dikonfirmasi</label>';
                                                    echo '<p style="float: left; color:rgba(60, 141, 188, 1);">#' . $i . ' : ' . tanggal_indo($value->tanggal_penjualan) . ' | ' . $jenis . '</p>' ?>
                                                </button>
                                            </a>
                                        </div>
                                        <div id="collapsemasuk<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $i; ?>">
                                            <div class="panel-body">
                                                <div style="overflow: auto;">
                                                    <?php
                                                    if ($value->jenis_pembayaran == 2) {
                                                    ?>
                                                        <?= Html::beginForm(['anggota-koperasi/print-tagihan', 'id' => $value->id_penjualan], 'post') ?>
                                                        <div class="col-xs-12" style="float:right;margin-top: 10px;margin-bottom: 10px;" id="form-tunai">
                                                            <div class="input-group mt-3">
                                                                <input class="form-control" type="number" id="bayar" name="bayar" placeholder="Input Pembayaran" aria-describedby="basic-addon1" />
                                                                <span class="input-group-btn" id="basic-addon1">
                                                                    <?= Html::submitButton('<span class="glyphicon glyphicon-print"></span> Cetak', ['class' => 'btn btn-warning pull-right']) ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?= Html::endForm() ?>
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    if ($value->jenis_pembayaran == 1) {
                                                        echo Html::a('Cetak', ['print-struk', 'id' => $value->id_penjualan], ['class' => 'btn btn-warning', 'style' => ['margin-bottom' => '10px']]);
                                                    }
                                                    ?>
                                                    <table class="table datatables">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th style="white-space: nowrap;">Keterangan Stok</th>
                                                                <th style="white-space: nowrap;">Nama Barang</th>
                                                                <th style="white-space: nowrap;">Harga Beli</th>
                                                                <th style="white-space: nowrap;">Qty</th>
                                                                <th style="white-space: nowrap;">Diskon</th>
                                                                <th style="white-space: nowrap;">PPN</th>
                                                                <th style="white-space: nowrap;">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $detail = DataPenjualanDetail::find()->where(['id_penjualan' => $value->id_penjualan])->all();

                                                            $no = 0;
                                                            $sum_masuk = 0;
                                                            foreach ($detail as $key => $val) {
                                                                $no++;
                                                                $sum_masuk += $val->total_jual;
                                                            ?>
                                                                <tr>
                                                                    <td><?= $no ?></td>
                                                                    <td><?= (!empty($val->stok_keluar->tanggal_keluar)) ? tanggal_indo($val->stok_keluar->tanggal_keluar, true) . ' - ' . $val->stok_keluar->keterangan : 'Data tidak ada/ sudah dihapus' ?></td>
                                                                    <td><?= (!empty($val->barang->nama_barang)) ? $val->barang->nama_barang : 'Barang tidak ada/ sudah dihapus' ?></td>
                                                                    <td><?= 'Rp. ' . number_format($val->harga_jual) ?></td>
                                                                    <td align="center"><?= $val->qty ?></td>
                                                                    <td align="center"><?= $val->diskon == 0 ? ' - ' : $val->diskon . " %" ?></td>
                                                                    <td align="center"><?= $val->ppn == 0 ? ' - ' : $val->ppn . " %" ?></td>
                                                                    <td align="right"><?= 'Rp. ' . number_format($val->total_jual) ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="7">Total</th>
                                                                <th style="float: right;">Rp. <?= number_format($sum_masuk) ?></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                // display pagination
                                echo LinkPager::widget([
                                    'pagination' => $pages,
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div id="tagihan" class="tab-pane fade" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <h3>Total Semua Tagihan</h3>
                                <?php
                                $penjualan_count = Yii::$app->db->createCommand("SELECT count(data_penjualan_barang.id_penjualan) FROM data_penjualan_detail LEFT JOIN data_penjualan_barang ON data_penjualan_barang.id_penjualan = data_penjualan_detail.id_penjualan WHERE data_penjualan_barang.id_anggota = '$model->id_anggota' AND data_penjualan_barang.jenis_pembayaran = '2'")->queryScalar();

                                if ($penjualan_count > 0) {
                                ?>
                                    <?= Html::beginForm(['anggota-koperasi/print-tagihan-semua', 'id' => $model->id_anggota], 'post') ?>
                                    <div class="col-xs-12" style="float:left;margin-top: 10px;margin-bottom: 10px;" id="form-tunai">
                                        <input class="form-control" type="hidden" id="bayar" name="bayar" placeholder="Input Pembayaran" aria-describedby="basic-addon1" />
                                        <!-- <div class="input-group mt-3">
                                        <span class="input-group-btn" id="basic-addon1">
                                        </span>
                                    </div> -->
                                        <?= Html::submitButton('Lunasi', ['class' => 'btn btn-warning pull-left']) ?>
                                        <?= Html::a('Download Tagihan', ['print-struk-semua', 'id' => $model->id_anggota], ['class' => 'btn btn-success', 'style' => ['margin-bottom' => '10px', 'margin-left' => '10px']]); ?>
                                    </div>
                                    <?= Html::endForm() ?>
                                <?php } ?>
                                <table class="table datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="white-space: nowrap;">Tanggal</th>
                                            <th style="white-space: nowrap;">Nama Barang</th>
                                            <th style="white-space: nowrap;">Harga</th>
                                            <th style="white-space: nowrap;">Qty</th>
                                            <th style="white-space: nowrap;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $gt = 0;
                                        $tagihan = Yii::$app->db->createCommand("SELECT * FROM data_penjualan_detail LEFT JOIN data_penjualan_barang ON data_penjualan_barang.id_penjualan = data_penjualan_detail.id_penjualan WHERE data_penjualan_barang.id_anggota = '$model->id_anggota' AND data_penjualan_barang.jenis_pembayaran = '2'")->query();

                                        foreach ($tagihan as $key => $value) {
                                            $barang = DataBarang::find()->where(['id_barang' => $value['id_barang']])->one();
                                            $gt += $value['total_jual'];
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= (!empty($value['tanggal_penjualan'])) ? tanggal_indo($value['tanggal_penjualan']) : '' ?></td>
                                                <td><?= (!empty($barang->nama_barang)) ? $barang->nama_barang : 'Data barang tidak ada/ sudah dihapus' ?></td>
                                                <td><?= (!empty($barang->harga_jual)) ? 'Rp. ' . number_format($barang->harga_jual) : 'Data barang tidak ada/ sudah dihapus' ?></td>
                                                <td><?= $value['qty'] ?></td>
                                                <td><?= 'Rp. ' . number_format($value['total_jual']) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5"></th>
                                            <th><?= 'Rp. ' . number_format($gt) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
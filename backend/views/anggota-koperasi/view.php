<?php

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
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header">
            <h3 style="font-weight: bold;">History Pembelian</h3>
        </div>
        <div class="box-body">
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
                                echo '<p style="float: left; color:rgba(60, 141, 188, 1);">#' . $i . ' : ' . tanggal_indo($value->tanggal_penjualan) . ' | ' . 'Rp. ' . number_format($value->grandtotal) . ' | ' . $jenis . '</p>' ?>
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
                                                <td><?= (!empty($val->barang->nama_barang)) ? $$val->barang->nama_barang : 'Barang tidak ada/ sudah dihapus' ?></td>
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
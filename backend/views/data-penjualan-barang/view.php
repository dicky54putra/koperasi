<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanBarang */

$this->title = 'Detail Penjualan';
$this->params['breadcrumbs'][] = ['label' => 'Data Penjualan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-penjualan-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::button(
            '<span class="glyphicon glyphicon-edit"></span> Ubah',
            [
                'value' => Url::to(['update', 'id' => $model->id_penjualan]),
                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-primary'
            ]
        ); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penjualan], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-warning">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id_penjualan',
                    [
                        'attribute' => 'tanggal_penjualan',
                        // 'label' => 'Tanggal penjualan',
                        'value' => function ($model) {
                            return tanggal_indo($model->tanggal_penjualan, true);
                        }
                    ],
                    [
                        'attribute' => 'id_anggota',
                        'label' => 'Nama Anggota',
                        'format' => 'html',
                        'value' => function ($model) {

                            return $model->anggota->nama_anggota;
                        }
                    ],
                    [
                        'attribute' => 'jenis_pembayaran',
                        'value' => function ($model) {

                            return $model->jenis_pembayaran == 1 ? 'LUNAS' : 'TAGIHAN';
                        }
                    ],
                    [
                        'attribute' => 'grandtotal',
                        'value' => function ($model) {

                            return $model->grandtotal;
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header"><h3 style="font-weight: bold;">History Penjualan</h3></div>
            <div class="box-body">

                <p>
                    <?= Html::button(
                        '<span class="glyphicon glyphicon-plus"></span> Tambah Data',
                        [
                            'value' => Url::to(['data-penjualan-detail/create', 'id' => $_GET['id']]),
                            'title' => 'Buat Data Pembelian', 'class' => 'showModalButton btn btn-success'
                        ]
                    ); ?>
                </p><br>

                <table class="table" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th style="white-space: nowrap;">Aksi</th>
                                <th style="white-space: nowrap;">Keterangan Stok</th>
                                <th style="white-space: nowrap;">Nama Barang</th>
                                <th style="white-space: nowrap;">Qty</th>
                                <th style="white-space: nowrap;">Diskon</th>
                                <th style="white-space: nowrap;">Harga Beli</th>
                                <th style="white-space: nowrap;">PPN</th>
                                <th style="white-space: nowrap;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($penjualan_detail as $key => $value) {
                            ?>

                                <tr>
                                   
                                    <td><?= $i++; ?>.</td>
                                    <td>
                                       
                                        <?= Html::button(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            [
                                                'value' => Url::to(['data-penjualan-detail/update', 'id' => $_GET['id'], 'id_detail' => $value->id_penjualan_detail]),
                                                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-primary'
                                            ]
                                        ); ?>
                                        <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_penjualan_detail], [
                                            'title' => Yii::t('app', 'Hapus data'),
                                        ]); ?>
                                    </td>
                                    <td><?= tanggal_indo($value->stok_keluar->tanggal_keluar, true) .' - '. $value->stok_keluar->keterangan?></td>
                                    <td><?= $value->barang->nama_barang ?></td>
                                    <td><?= $value->qty ?></td>
                                    <td><?= $value->diskon ?></td>
                                    <td><?= $value->harga_jual ?></td>
                                    <td><?= $value->ppn ?></td>
                                    <td><?= $value->total_jual ?></td>

                                </tr>

                            <?php } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <!-- <td>T</td> -->
                            </tr>
                        </tfoot>
                    </table>

            
            </div>
    </div>

</div>

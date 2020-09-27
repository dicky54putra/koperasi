<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianBarang */

$this->title = 'Detail Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Data Pembelian Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-pembelian-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::button(
            '<span class="glyphicon glyphicon-edit"></span> Ubah',
            [
                'value' => Url::to(['update', 'id' => $model->id_pembelian]),
                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-primary'
            ]
        ); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pembelian], [
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
                    // 'id_pembelian',
                    // 'tanggal_pembelian',
                    [
                        'attribute' => 'tanggal_pembelian',
                        'label' => 'Tanggal Pembelian',
                        'value' => function ($model) {
                            return tanggal_indo($model->tanggal_pembelian, true);
                        }
                    ],
                    [
                        'attribute' => 'id_anggota',
                        'label' => 'Supplier',
                        'format' => 'html',
                        'value' => function ($model) {

                            return $model->id_anggota == NULL ? '<i>Tidak ada Supplier</i>' : $model->anggota->nama_anggota;
                        }
                    ],
                    'no_faktur',
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
        <div class="box-header"><h3 style="font-weight: bold;">History Pembelian</h3></div>
            <div class="box-body">

                <p>
                    <?= Html::button(
                        '<span class="glyphicon glyphicon-plus"></span> Tambah Data',
                        [
                            'value' => Url::to(['data-pembelian-detail/create', 'id' => $_GET['id']]),
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
                            foreach ($pembelian_detail as $key => $value) {
                            ?>

                                <tr>
                                   
                                    <td><?= $i++; ?>.</td>
                                    <td>
                                       
                                        <?= Html::button(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            [
                                                'value' => Url::to(['data-pembelian-detail/update', , 'id' => $_GET['id'], 'id_detail' => $value->id_pembelian_detail]),
                                                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-primary'
                                            ]
                                        ); ?>
                                        <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_pembelian_detail], [
                                            'title' => Yii::t('app', 'Hapus data'),
                                        ]); ?>
                                    </td>
                                    <td><?= tanggal_indo($value->stok_masuk->tanggal_masuk, true) .' - '. $value->stok_masuk->keterangan?></td>
                                    <td><?= $value->barang->nama_barang ?></td>
                                    <td><?= $value->qty ?></td>
                                    <td><?= $value->diskon ?></td>
                                    <td><?= $value->harga_beli ?></td>
                                    <td><?= $value->ppn ?></td>
                                    <td><?= $value->total_beli ?></td>

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

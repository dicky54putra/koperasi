<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

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
                        'kode_anggota',
                        'nama_anggota',
                        [
                            'attribute' => 'kode_anggota', 
                            'format' => 'raw', 
                            'value'=> function($model){
                                return yii\helpers\Html::tag('div', '', ['id' => 'barcode-'.$model->kode_anggota]).
                                \barcode\barcode\BarcodeGenerator::widget([
                                    'elementId' => 'barcode-'.$model->kode_anggota,
                                    'value'=> $model->kode_anggota, 
                                    'type'=>'ean13',
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

            <table class="table" id="table-index">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">#</th>
                        <th style="white-space: nowrap;">Tanggal Pembelian</th>
                        <th style="white-space: nowrap;">Grandtotal</th>
                        <th style="white-space: nowrap;">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $grandtotal = 0;
                    foreach ($pembelian_history as $key => $value) {
                        // $grandtotal += $value->total_beli;
                    ?>

                        <tr>

                            <td><?= $i++; ?>.</td>
                            <td><?= tanggal_indo($value->tanggal_penjualan, true) ?></td>
                            <td><?= number_format($value->grandtotal) ?></td>
                            <td><?= $value->jenis_pembayaran == 1 ? 'LUNAS' : 'TAGIHAN' ?></td>

                        </tr>

                    <?php } ?>
                </tbody>
            </table>


        </div>
    </div>
</div>
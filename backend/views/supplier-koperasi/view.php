<?php

use backend\models\DataBarang;
use backend\models\DataPenjualanDetail;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model backend\models\AnggotaKoperasi */

$this->title = 'Detail Supplier : ' . $model->nama_anggota;
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
</div>
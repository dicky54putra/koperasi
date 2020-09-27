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
                            'value' => Url::to(['data-pembelian-detail/create']),
                            'title' => 'Buat Data Pembelian', 'class' => 'showModalButton btn btn-success'
                        ]
                    ); ?>
                </p>
            
            </div>
    </div>

</div>

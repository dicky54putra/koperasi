<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */

$this->title = 'Detail Barang : ' . $model->nama_barang;
$this->params['breadcrumbs'][] = ['label' => 'Data Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::button(
            '<span class="glyphicon glyphicon-edit"></span> Ubah',
            [
                'value' => Url::to(['update', 'id' => $model->id_barang]),
                'title' => 'Ubah data',
                'class' => 'showModalButton btn btn-primary'
            ]
        ); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_barang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-warning">
        <!-- <div class="box-header">
            </div> -->
        <div class="box-body">
            <div class="col-md-6" style="padding: 0;">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'kategori_barang.nama_kategori',
                            'satuan.nama_satuan',
                            'kode_barang',
                            'nama_barang',
                        ],
                    ]) ?>

                </div>
            </div>
            <div class="col-md-6" style="padding: 0;">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'anggota.nama_anggota',
                            'harga_jual',
                            'harga_beli',
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

            <div class="col-md-12" style="margin-top:20px;">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-truck-loading"></span> Stok Masuk</a></li>
                    <li><a data-toggle="tab" href="#data-penerimaan"><span class="fa fa-truck-loading"></span> Stok Keluar</a></li>
                </ul>
                <div class="tab-content">

                    <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            <div class="col-md-12" style="padding: 0;">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'kode_anggota',
                        'nama_anggota',
                        'alamat_anggota',
                        'kota',
                        'telp',
                        'npwp',
                        'id_jenis_anggota',
                        'id_pangkat',
                        'tanggal_keanggotaan',
                        'is_active',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div>
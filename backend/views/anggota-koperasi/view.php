<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AnggotaKoperasi */

$this->title = $model->id_anggota;
$this->params['breadcrumbs'][] = ['label' => 'Anggota Koperasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="anggota-koperasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_anggota], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_anggota], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_anggota',
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

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokKeluar */

$this->title = 'Ubah Stok Keluar: ' . substr(tanggal_indo($model->tanggal_keluar), 2, -4);
$this->params['breadcrumbs'][] = ['label' => 'Stok Keluars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_stok_keluar, 'url' => ['view', 'id' => $model->id_stok_keluar]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stok-keluar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
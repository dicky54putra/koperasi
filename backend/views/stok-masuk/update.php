<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokMasuk */

$this->title = 'Update Stok Masuk: ' . tanggal_indo($model->tanggal_masuk);
$this->params['breadcrumbs'][] = ['label' => 'Stok Masuks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_stok_masuk, 'url' => ['view', 'id' => $model->id_stok_masuk]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stok-masuk-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
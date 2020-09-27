<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanBarang */

$this->title = 'Update Data Penjualan Barang: ' . $model->id_penjualan;
$this->params['breadcrumbs'][] = ['label' => 'Data Penjualan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_penjualan, 'url' => ['view', 'id' => $model->id_penjualan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-penjualan-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

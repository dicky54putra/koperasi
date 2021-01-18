<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanDetail */

$this->title = 'Data Penjualan Detail';
$this->params['breadcrumbs'][] = ['label' => 'Data Penjualan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-penjualan-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'data_barang' => $data_barang,
        'data_stok_keluar' => $data_stok_keluar,
    ]) ?>

</div>
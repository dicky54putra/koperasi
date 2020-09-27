<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanBarang */

$this->title = 'Create Data Penjualan Barang';
$this->params['breadcrumbs'][] = ['label' => 'Data Penjualan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-penjualan-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
            'data_anggota' => $data_anggota,
    ]) ?>

</div>

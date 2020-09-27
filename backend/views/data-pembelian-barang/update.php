<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianBarang */

$this->title = 'Update Data Pembelian Barang: ' . $model->id_pembelian;
$this->params['breadcrumbs'][] = ['label' => 'Data Pembelian Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pembelian, 'url' => ['view', 'id' => $model->id_pembelian]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-pembelian-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

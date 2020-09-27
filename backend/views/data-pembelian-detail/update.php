<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianDetail */

$this->title = 'Update Data Pembelian Detail: ' . $model->id_pembelian_detail;
$this->params['breadcrumbs'][] = ['label' => 'Data Pembelian Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pembelian_detail, 'url' => ['view', 'id' => $model->id_pembelian_detail]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-pembelian-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataSatuan */

$this->title = 'Ubah Data Satuan: ' . $model->nama_satuan;
$this->params['breadcrumbs'][] = ['label' => 'Data Satuans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_satuan, 'url' => ['view', 'id' => $model->id_satuan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-satuan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */

$this->title = 'Ubah Data Barang';
// $this->params['breadcrumbs'][] = ['label' => 'Data Barangs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_barang, 'url' => ['view', 'id' => $model->id_barang]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data_satuan' => $data_satuan,
        'data_kategori' => $data_kategori,
        'data_supplier' => $data_supplier,
    ]) ?>

</div>
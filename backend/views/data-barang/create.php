<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */

$this->title = 'Detail Data Barang';
// $this->params['breadcrumbs'][] = ['label' => 'Data Barangs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
            'data_satuan' => $data_satuan,
            'data_kategori' => $data_kategori,
            'data_supplier' => $data_supplier,
    ]) ?>

</div>

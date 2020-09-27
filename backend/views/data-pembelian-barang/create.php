<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianBarang */

$this->title = 'Create Data Pembelian Barang';
$this->params['breadcrumbs'][] = ['label' => 'Data Pembelian Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pembelian-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
            'data_supplier' => $data_supplier,
    ]) ?>

</div>

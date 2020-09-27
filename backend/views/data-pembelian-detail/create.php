<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianDetail */

$this->title = 'Create Data Pembelian Detail';
$this->params['breadcrumbs'][] = ['label' => 'Data Pembelian Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pembelian-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

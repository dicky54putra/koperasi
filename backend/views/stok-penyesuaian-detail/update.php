<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokPenyesuaianDetail */

$this->title = 'Update Stok Penyesuaian Detail: ' . $model->id_stok_penyesuaian_detail;
$this->params['breadcrumbs'][] = ['label' => 'Stok Penyesuaian Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_stok_penyesuaian_detail, 'url' => ['view', 'id' => $model->id_stok_penyesuaian_detail]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stok-penyesuaian-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

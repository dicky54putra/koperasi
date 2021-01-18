<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokPenyesuaian */

$this->title = 'Update Stok Penyesuaian: ' . $model->id_stok_penyesuaian;
$this->params['breadcrumbs'][] = ['label' => 'Stok Penyesuaians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_stok_penyesuaian, 'url' => ['view', 'id' => $model->id_stok_penyesuaian]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stok-penyesuaian-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

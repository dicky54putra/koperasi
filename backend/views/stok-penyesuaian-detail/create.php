<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokPenyesuaianDetail */

$this->title = 'Create Stok Penyesuaian Detail';
$this->params['breadcrumbs'][] = ['label' => 'Stok Penyesuaian Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-penyesuaian-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

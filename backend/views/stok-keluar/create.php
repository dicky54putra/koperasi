<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokKeluar */

$this->title = 'Create Stok Keluar';
$this->params['breadcrumbs'][] = ['label' => 'Stok Keluars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-keluar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

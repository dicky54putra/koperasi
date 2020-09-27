<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokMasuk */

$this->title = 'Create Stok Masuk';
$this->params['breadcrumbs'][] = ['label' => 'Stok Masuks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-masuk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

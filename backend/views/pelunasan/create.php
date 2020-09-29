<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pelunasan */

$this->title = 'Buat Data Pelunasan';
$this->params['breadcrumbs'][] = ['label' => 'Pelunasans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelunasan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

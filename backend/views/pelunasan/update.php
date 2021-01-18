<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pelunasan */

$this->title = 'Ubah Data Pelunasan ';
$this->params['breadcrumbs'][] = ['label' => 'Pelunasans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pelunasan, 'url' => ['view', 'id' => $model->id_pelunasan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pelunasan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

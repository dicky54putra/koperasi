<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPangkat */

$this->title = 'Tambah Data Pangkat: ' . $model->id_pangkat;
$this->params['breadcrumbs'][] = ['label' => 'Data Pangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pangkat, 'url' => ['view', 'id' => $model->id_pangkat]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-pangkat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JenisAnggota */

$this->title = 'Update Jenis Anggota: ' . $model->id_jenis;
$this->params['breadcrumbs'][] = ['label' => 'Jenis Anggotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_jenis, 'url' => ['view', 'id' => $model->id_jenis]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jenis-anggota-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

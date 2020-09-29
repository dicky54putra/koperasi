<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */

$this->title = 'Update Simpan Pinjam: ' . $model->id_simpan_pinjam;
$this->params['breadcrumbs'][] = ['label' => 'Simpan Pinjams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_simpan_pinjam, 'url' => ['view', 'id' => $model->id_simpan_pinjam]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="simpan-pinjam-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AnggotaKoperasi */

$this->title = 'Tambah Supplier Koperasi';
?>
<div class="anggota-koperasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
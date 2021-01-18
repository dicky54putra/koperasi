<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="simpan-pinjam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_simpan_pinjam') ?>

    <?= $form->field($model, 'id_anggota') ?>

    <?= $form->field($model, 'jenis') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PelunasanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelunasan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pelunasan') ?>

    <?= $form->field($model, 'id_simpan_pinjam') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'nominal') ?>

    <?= $form->field($model, 'catatan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

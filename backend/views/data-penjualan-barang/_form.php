<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanBarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-penjualan-barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tanggal_penjualan')->textInput() ?>

    <?= $form->field($model, 'id_anggota')->textInput() ?>

    <?= $form->field($model, 'jenis_pembayaran')->dropDownList([ 1 => '1', 2 => '2', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

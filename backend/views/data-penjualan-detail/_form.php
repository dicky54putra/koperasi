<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-penjualan-detail-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'id_penjualan')->textInput() ?>

    <?= $form->field($model, 'id_stok_keluar')->textInput() ?>

    <?= $form->field($model, 'id_barang')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'diskon')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    <?= $form->field($model, 'ppn')->textInput() ?>

    <?= $form->field($model, 'total_jual')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

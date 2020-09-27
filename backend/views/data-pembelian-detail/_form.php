<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-pembelian-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pembelian')->textInput() ?>

    <?= $form->field($model, 'id_stok_masuk')->textInput() ?>

    <?= $form->field($model, 'id_barang')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'diskon')->textInput() ?>

    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'ppn')->textInput() ?>

    <?= $form->field($model, 'total_beli')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

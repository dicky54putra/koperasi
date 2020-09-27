<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-pembelian-detail-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-detail',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'id_pembelian')->textInput(['value' => $_GET['id'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'id_stok_masuk')->widget(Select2::classname(), [
                // 'name' => 'test',
                'data' => $data_stok_masuk,
                // 'hashVarLoadPosition' => View::POS_READY,
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Data Stok Masuk'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Stok Masuk Pada Tanggal') ?>

    <?= $form->field($model, 'id_barang')->widget(Select2::classname(), [
                // 'name' => 'test',
                'data' => $data_barang,
                // 'hashVarLoadPosition' => View::POS_READY,
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Barang'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Barang') ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'diskon')->textInput() ?>

    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'ppn')->textInput() ?>

    <?= $form->field($model, 'total_beli')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

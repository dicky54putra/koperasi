<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

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

    <?= $form->field($model, 'id_penjualan')->textInput(['value' => $_GET['id'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'id_stok_keluar')->widget(Select2::classname(), [
                // 'name' => 'test',
                'data' => $data_stok_keluar,
                // 'hashVarLoadPosition' => View::POS_READY,
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Data Stok Keluar'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Stok Keluar Pada Bulan') ?>

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

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    <?= $form->field($model, 'ppn')->textInput() ?>

    <?= $form->field($model, 'total_jual')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

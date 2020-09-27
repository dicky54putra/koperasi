<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanBarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-penjualan-barang-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'tanggal_penjualan')->widget(\yii\jui\DatePicker::classname(), [

            'clientOptions' => [
                        'changeMonth'=>true, 
                        'changeYear'=>true,
            ],
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control', 'autocomplete'=>'off']
    ]) ?>

    <?= $form->field($model, 'id_anggota')->widget(Select2::classname(), [
                // 'name' => 'test',
                'data' => $data_anggota,
                // 'hashVarLoadPosition' => View::POS_READY,
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Anggota'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Anggota') ?>

    <?= $form->field($model, 'jenis_pembayaran')->dropDownList([ 1 => 'LUNAS', 2 => 'TAGIHAN', ], ['prompt' => 'Pilih Status Pembayaran']) ?>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

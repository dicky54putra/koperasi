<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pinjam-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

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

    <?= $form->field($model, 'jenis')->dropDownList([ 2 => 'PINJAMAN'], ['readonly' => true]) ?>

    <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [

            'clientOptions' => [
                        'changeMonth'=>true, 
                        'changeYear'=>true,
            ],
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control', 'autocomplete'=>'off']
    ]) ?>


    <?= $form->field($model, 'nominal')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 1 => 'AKTIF', 2 => 'NONAKTIF']) ?>
    
    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

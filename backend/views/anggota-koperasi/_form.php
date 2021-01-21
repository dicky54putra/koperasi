<?php

use backend\models\DataPangkat;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AnggotaKoperasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggota-koperasi-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-anggota-koperasi',
            'tabindex' => false,
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'kode_anggota')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'nama_anggota')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'alamat_anggota')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'kota')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>

            <?php
            $model->id_jenis_anggota = 1;
            echo $form->field($model, 'id_jenis_anggota')->textInput(['type' => 'hidden'])->label(false); ?>

            <?= $form->field($model, 'id_pangkat')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(
                    DataPangkat::find()->all(),
                    'id_pangkat',
                    function ($model) {
                        return $model['nama_pangkat'];
                    }
                ),
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Jenis Anggota'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Pangkat'); ?>

            <?php
            $model->tanggal_keanggotaan = date('Y-m-d');
            echo $form->field($model, 'tanggal_keanggotaan')->widget(\yii\jui\DatePicker::classname(), [

                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'autocomplete' => 'off']
            ]) ?>

            <?= $form->field($model, 'is_active')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'))->label('Status') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::Button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
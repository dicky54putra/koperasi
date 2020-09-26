<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

            <?= $form->field($model, 'id_jenis_anggota')->textInput() ?>

            <?= $form->field($model, 'id_pangkat')->textInput() ?>

            <?= $form->field($model, 'tanggal_keanggotaan')->textInput() ?>

            <?= $form->field($model, 'is_active')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
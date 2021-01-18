<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPangkat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-pangkat-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'nama_pangkat')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::Button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StokMasuk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stok-masuk-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-stok-masuk',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'id_barang')->textInput(['value' => $_GET['id'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'total_qty')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'tanggal_masuk')->widget(\yii\jui\DatePicker::classname(), [
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ],
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'autocomplete' => 'off']
    ]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
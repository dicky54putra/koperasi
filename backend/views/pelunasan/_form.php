<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Pelunasan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelunasan-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'id_simpan_pinjam')->textInput(['value' => $_GET['id'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [

            'clientOptions' => [
                        'changeMonth'=>true, 
                        'changeYear'=>true,
            ],
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control', 'autocomplete'=>'off']
    ]) ?>

    <?= $form->field($model, 'nominal')->textInput() ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

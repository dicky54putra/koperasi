<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StokPenyesuaianDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stok-penyesuaian-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_stok_penyesuaian')->textInput() ?>

    <?= $form->field($model, 'id_barang')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

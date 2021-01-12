<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_barang') ?>

    <?= $form->field($model, 'id_kategori') ?>

    <?= $form->field($model, 'id_satuan') ?>

    <?= $form->field($model, 'kode_barang') ?>

    <?= $form->field($model, 'nama_barang') ?>

    <?php // echo $form->field($model, 'id_anggota') ?>

    <?php // echo $form->field($model, 'harga_jual') ?>

    <?php // echo $form->field($model, 'harga_beli') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-barang-form">

     <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'kode_barang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_barang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kategori')->widget(Select2::classname(), [
                                            // 'name' => 'test',
                                            'data' => $data_kategori,
                                            // 'hashVarLoadPosition' => View::POS_READY,
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Pilih Kategori'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label('Kategori') ?>

    <?= $form->field($model, 'id_satuan')->widget(Select2::classname(), [
                                            // 'name' => 'test',
                                            'data' => $data_satuan,
                                            // 'hashVarLoadPosition' => View::POS_READY,
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Pilih Satuan'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label('Satuan') ?>

    

    <?= $form->field($model, 'id_anggota')->widget(Select2::classname(), [
                                            // 'name' => 'test',
                                            'data' => $data_supplier,
                                            // 'hashVarLoadPosition' => View::POS_READY,
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Pilih Supplier'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label('Supplier') ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'is_active')->dropDownList(array(1=>"Aktif",2=>"Nonaktif"))->label('Status') ?>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

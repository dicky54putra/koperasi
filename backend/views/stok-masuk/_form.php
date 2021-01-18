<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

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

    <?= $form->field($model, 'id_barang')->textInput(['value' => $_GET['id_barang'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'total_qty')->textInput(['type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'tanggal_masuk')->widget(Select2::classname(), [
        // 'name' => 'test',
        'data' => array(
            date('Y') . '-01-' . date('d', strtotime(1)) => 'Januari',
            date('Y') . '-02-' . date('d', strtotime(1)) => 'Febuari',
            date('Y') . '-03-' . date('d', strtotime(1)) => 'Maret',
            date('Y') . '-04-' . date('d', strtotime(1)) => 'April',
            date('Y') . '-05-' . date('d', strtotime(1)) => 'Mei',
            date('Y') . '-06-' . date('d', strtotime(1)) => 'Juni',
            date('Y') . '-07-' . date('d', strtotime(1)) => 'Juli',
            date('Y') . '-08-' . date('d', strtotime(1)) => 'Agustus',
            date('Y') . '-09-' . date('d', strtotime(1)) => 'September',
            date('Y') . '-10-' . date('d', strtotime(1)) => 'Oktober',
            date('Y') . '-11-' . date('d', strtotime(1)) => 'November',
            date('Y') . '-12-' . date('d', strtotime(1)) => 'Desember',
        ),
        // 'hashVarLoadPosition' => View::POS_READY,
        'language' => 'en',
        'options' => ['placeholder' => 'Pilih Kategori'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::Button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
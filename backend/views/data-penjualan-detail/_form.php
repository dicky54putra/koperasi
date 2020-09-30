<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    $('#id_barang').change(function() {
        var id = $(this).val();


        $.get('index.php?r=data-penjualan-detail/get-data-barang', {
            id: id
        }, function(data) {
            var data = $.parseJSON(data);
            $('#datapenjualandetail-harga_jual').attr('value', data.harga_jual);
            $('#datapenjualandetail-qty').val('1');
            $('#datapenjualandetail-diskon').val('0');
            $('#datapenjualandetail-ppn').val('0');

        });
    });

    function hitung() {
        var harga_jual = $('#datapenjualandetail-harga_jual').val();
        var qty = $('#datapenjualandetail-qty').val();
        var diskon = $('#datapenjualandetail-diskon').val();
        var ppn = $('#datapenjualandetail-ppn').val();
        var total = harga_jual * qty;

        var diskon = total - (total * diskon / 100);

        var pajak = diskon + (diskon * ppn / 100);

        // console.log(total);
        $('#datapenjualandetail-total_jual').val(pajak);

    }
</script>

<div class="data-penjualan-detail-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'id_penjualan')->textInput(['value' => $_GET['id'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'id_barang')->widget(Select2::classname(), [
        // 'name' => 'test',
        'data' => $data_barang,
        // 'hashVarLoadPosition' => View::POS_READY,
        'language' => 'en',
        'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_barang'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Barang') ?>

    <?= $form->field($model, 'id_stok_keluar')->widget(DepDrop::classname(), [
        // 'data' => $data_stok_keluar,
        'type' => DepDrop::TYPE_SELECT2,
        'options' => ['placeholder' => 'Select ...'],
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'pluginOptions' => [
            'depends' => ['id_barang'],
            'url' => Url::to(['/data-penjualan-detail/stok']),
            // 'loadingText' => 'Loading  Keluar Pada Bulan ...',
        ]
    ])->label('Stok Keluar Pada Bulan') ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'harga_jual')->textInput() ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'qty')->textInput() ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'diskon')->textInput() ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'ppn')->textInput() ?>
        </div>

        <div class="col-md-1" style="margin-top: 25px;">
            <a class="btn btn-success" onclick="hitung()"><i class="fa fa-fw fa-refresh"></i></a>
        </div>

    </div>

    <?= $form->field($model, 'total_jual')->textInput(['readonly' => 'true']) ?>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
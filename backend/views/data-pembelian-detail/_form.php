<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianDetail */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
    $('#datapembeliandetail-id_barang').change(function(){
        var id = $(this).val();


        $.get('index.php?r=data-pembelian-detail/get-data-barang',{ id : id },function(data){
            var data = $.parseJSON(data);
            $('#datapembeliandetail-harga_beli').attr('value',data.harga_beli);
            $('#datapembeliandetail-qty').val('1');
            $('#datapembeliandetail-diskon').val('0');
            $('#datapembeliandetail-ppn').val('0');

        });
    });

    function hitung() {
        var harga_beli = $('#datapembeliandetail-harga_beli').val();
        var qty = $('#datapembeliandetail-qty').val();
        var diskon = $('#datapembeliandetail-diskon').val();
        var ppn = $('#datapembeliandetail-ppn').val();
        var total = harga_beli * qty;

        var diskon = total - (total * diskon/100);

        var pajak = diskon + (diskon * ppn/100);

        // console.log(total);
        $('#datapembeliandetail-total_beli').val(pajak);

    }
</script>
<div class="data-pembelian-detail-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-detail',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'id_pembelian')->textInput(['value' => $_GET['id'], 'type' => 'hidden'])->label(false) ?>

    <?= $form->field($model, 'id_stok_masuk')->widget(Select2::classname(), [
                // 'name' => 'test',
                'data' => $data_stok_masuk,
                // 'hashVarLoadPosition' => View::POS_READY,
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Data Stok Masuk'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Stok Masuk Pada Tanggal') ?>

    <?= $form->field($model, 'id_barang')->widget(Select2::classname(), [
                // 'name' => 'test',
                'data' => $data_barang,
                // 'hashVarLoadPosition' => View::POS_READY,
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Barang'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Barang') ?>

        <div class="row">
            <div class="col-md-5">
                <?= $form->field($model, 'harga_beli')->textInput() ?>
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

    <?= $form->field($model, 'total_beli')->textInput(['readonly' => 'true']) ?>

    <div class="form-group">
        <?= Html::submitButton('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataPenjualanBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penjualan Barang';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="data-penjualan-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="row">
        <!-- <div class="col-md-12">
            <div class="panel">
                <div class="panel-body"></div>
            </div>
        </div> -->
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?php
                    echo $form->field($model, 'id_anggota')->widget(Select2::classname(), [
                        // 'name' => 'test',
                        'data' => $data_anggota_,
                        // 'hashVarLoadPosition' => View::POS_READY,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Anggota', 'id' => 'data_anggota_', 'name' => 'data_anggota_', 'class' => 'hidden'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'open' => true,
                            'hide' => true,
                        ],
                    ])->label(false)
                    ?>
                    <?php
                    echo $form->field($model, 'id_anggota')->textInput(['type' => 'text', 'autofocus' => true])->label(false);
                    ?>
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <button class="btn btn-info form-control" id="customer_manual">Cari Manual</button>
                    <button class="btn btn-success form-control" id="customer_barcode" style="margin-top: 20px;">Dengan Barcode</button>
                    <!-- <button class="btn btn-warning form-control" style="margin-top: 20px;" id="customer_umum">Customer Umum</button> -->
                    <?= Html::a('Customer Umum', ['penjualan-umum'], ['class' => 'btn btn-warning form-control', 'style' => 'margin-top: 20px;']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    $('#data_anggota_').parent().hide();
    $('#customer_barcode').addClass('disabled');
    $('#data_anggota_').change(function (){
        const isi = $('#data_anggota_').val();
        $('#datapenjualanbarang-id_anggota').val(isi);
    })
    $('#customer_manual').click(function (){
        $('#datapenjualanbarang-id_anggota').hide();
        $('#data_anggota_').parent().show();
        $(this).addClass('disabled');
        $('#customer_barcode').removeClass('disabled');
    })
    $('#customer_barcode').click(function (){
        $('#datapenjualanbarang-id_anggota').show();
        $('#data_anggota_').parent().hide();
        $(this).addClass('disabled');
        $('#customer_manual').removeClass('disabled');
        $('#datapenjualanbarang-id_anggota').focus();
        $('#datapenjualanbarang-id_anggota').val(null);
    })
    JS;
$this->registerJs($script);
?>
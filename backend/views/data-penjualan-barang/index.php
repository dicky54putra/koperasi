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
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-header">
                    <h3 style="margin-left: 10px;">History Penjualan</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <!-- <th style="white-space: nowrap;">Aksi</th> -->
                                <th style="white-space: nowrap;">Tanggal Penjualan</th>
                                <th style="white-space: nowrap;">Nama Customer</th>
                                <th style="white-space: nowrap;">Jenis Pembayaran</th>
                                <!-- <th style="white-space: nowrap;">Grandtotal Penjualan</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($data_penjualan as $key => $value) {
                            ?>
                                <tr class='clickable-row' data-href="index.php?r=data-penjualan-barang/view&id=<?= $value->id_penjualan ?>" style="cursor: pointer;">
                                    <td><?= $i++; ?>.</td>
                                    <!-- <td>
                                        <?= Html::a('<button class = "btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>', ['view', 'id' => $value->id_penjualan], [
                                            'title' => Yii::t('app', 'Lihat Detail'),
                                        ]); ?>
                                        <?= Html::button(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            [
                                                'value' => Url::to(['update', 'id' => $value->id_penjualan]),
                                                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-success'
                                            ]
                                        ); ?>
                                        <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_penjualan], [
                                            'title' => Yii::t('app', 'Hapus data'),
                                            'class' => 'tombol-hapus'
                                        ]); ?>
                                    </td> -->
                                    <td><?= tanggal_indo($value->tanggal_penjualan) ?></td>
                                    <td><?= ($value->id_anggota != 0) ? $value->anggota->nama_anggota : 'Customer Umum';
                                        ?></td>
                                    <td><?= ($value->jenis_pembayaran == null) ? 'Belum dikonfirmasi' : $retVal = ($value->jenis_pembayaran == 2) ? 'TAGIHAN' : 'LUNAS'; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <!-- <td>T</td> -->
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <h3>Tambah Penjualan Baru</h3>
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
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    JS;
$this->registerJs($script);
?>
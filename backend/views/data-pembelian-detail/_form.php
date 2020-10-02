<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianDetail */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
    $('#id_barang').change(function() {
        var id = $(this).val();


        $.get('index.php?r=data-pembelian-detail/get-data-barang', {
            id: id
        }, function(data) {
            var data = $.parseJSON(data);
            $('#datapembeliandetail-harga_beli').attr('value', data.harga_beli);
            $('#datapembeliandetail-qty').val('1');
            $('#datapembeliandetail-diskon').val('0');
            $('#datapembeliandetail-ppn').val('0');
            $('#stokmasuk-id_barang').val(data.id_barang);

        });
    });

    function hitung() {
        var harga_beli = $('#datapembeliandetail-harga_beli').val();
        var qty = $('#datapembeliandetail-qty').val();
        var diskon = $('#datapembeliandetail-diskon').val();
        var ppn = $('#datapembeliandetail-ppn').val();
        var total = harga_beli * qty;

        var diskon = total - (total * diskon / 100);

        var pajak = diskon + (diskon * ppn / 100);

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

    <?= $form->field($model, 'id_stok_masuk')->widget(DepDrop::classname(), [
        // 'data' => $data_stok_keluar,
        'type' => DepDrop::TYPE_SELECT2,
        'options' => ['placeholder' => 'Select ...'],
        'select2Options' => [
            'pluginOptions' => ['allowClear' => true],
            'addon' => [
                'prepend' => [
                    'content' => Html::a('<span class="glyphicon glyphicon-plus"></span>', '#', [
                        'class' => 'btn btn-success plus ',
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-penerimaan-detail',
                        'style' => [
                            'float' => 'right'
                        ],
                        // 'data-id' => $d->id_pembelian_penerimaan
                    ]),
                    'asButton' => true
                ],
            ],
        ],
        'pluginOptions' => [
            'depends' => ['id_barang'],
            'url' => Url::to(['/data-pembelian-detail/stok']),
            // 'loadingText' => 'Loading  Keluar Pada Bulan ...',
        ]
    ])->label('Stok Masuk Pada Tanggal') ?>

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
        <?= Html::Button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="modal fade" id="modal-penerimaan-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terima Barang Detail</h4>
            </div>
            <?php //$form = ActiveForm::begin(['akt-pembelian/view', 'aksi' => 'ubah_data_pembelian', 'id' => $model->id_pembelian]); 
            ?>
            <?php $form = ActiveForm::begin([
                'action' => 'index.php?r=data-pembelian-barang/create-stok&id=' . $_GET['id'],
            ]); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model2, 'id_barang')->textInput(['type' => 'hidden'])->label(false) ?>

                        <?= $form->field($model2, 'total_qty')->textInput(['type' => 'hidden'])->label(false) ?>

                        <?= $form->field($model2, 'tanggal_masuk')->widget(Select2::classname(), [
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
                        <?= $form->field($model2, 'keterangan')->textarea(['rows' => 6]) ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                <?php // Html::endForm() 
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
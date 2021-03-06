<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\DataPangkat;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianBarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-pembelian-barang-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-data-barang',
            'tabindex' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'tanggal_pembelian')->widget(\yii\jui\DatePicker::classname(), [

        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ],
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'autocomplete' => 'off']
    ]) ?>

    <?= $form->field($model, 'id_anggota')->widget(Select2::classname(), [
        // 'name' => 'test',
        'data' => $data_supplier,
        // 'hashVarLoadPosition' => View::POS_READY,
        'language' => 'en',
        'options' => ['placeholder' => 'Pilih Supplier'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'addon' => [
            'prepend' => [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span>', '#', [
                    'class' => 'btn btn-success plus ',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-view',
                    'style' => [
                        'float' => 'right'
                    ],
                    // 'data-id' => $d->id_pembelian_penerimaan
                ]),
                'asButton' => true
            ],
        ],
    ])->label('Supplier') ?>

    <?= $form->field($model, 'no_faktur')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::Button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?> </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="modal fade" id="modal-view">
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
                'action' => 'index.php?r=data-pembelian-barang/create-anggota',
            ]); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model2, 'kode_anggota')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model2, 'nama_anggota')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model2, 'alamat_anggota')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model2, 'kota')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model2, 'telp')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model2, 'npwp')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model2, 'id_jenis_anggota')->widget(Select2::classname(), [
                            'data' => array(2 => 'Supplier'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Jenis Anggota'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>

                        <?= $form->field($model2, 'id_pangkat')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(
                                DataPangkat::find()->all(),
                                'id_pangkat',
                                function ($model2) {
                                    return $model2['nama_pangkat'];
                                }
                            ),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Jenis Anggota'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pangkat'); ?>

                        <?= $form->field($model2, 'tanggal_keanggotaan')->textInput(['type' => 'date']) ?>

                        <?= $form->field($model2, 'is_active')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'))->label('Status') ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
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
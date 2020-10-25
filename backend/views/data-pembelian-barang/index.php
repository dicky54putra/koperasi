<?php

use backend\models\AnggotaKoperasi;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataPembelianBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pembelian Barang';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pembelian-barang-index">

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
                    <h3 style="margin-left: 10px;">History Pembelian Baru</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th style="white-space: nowrap;">Tanggal Pembelian</th>
                                <th style="white-space: nowrap;">Supplier</th>
                                <th style="white-space: nowrap;">No. Faktur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($data_pembelian as $key => $value) {
                                $anggota = AnggotaKoperasi::find()->where(['id_anggota' => $value->id_anggota])->one();
                            ?>

                                <tr class='clickable-row' data-href="index.php?r=data-pembelian-barang/view&id=<?= $value->id_pembelian ?>" style="cursor: pointer;">
                                    <td><?= $i++; ?>.</td>
                                    <td><?= tanggal_indo($value->tanggal_pembelian) ?></td>
                                    <td><?= $value->id_anggota == NULL ? '<i>Tidak ada supplier</i>' : $retVal = (!empty($anggota->nama_anggota)) ? $anggota->nama_anggota : 'Supplier tidak ada/ sudah dihapus'; ?></td>
                                    <td><?= $value->no_faktur ?></td>
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
                    <h3>Tambah Pembelian Baru</h3>
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_anggota')->widget(Select2::classname(), [
                        'data' => $data_supplier,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Supplier'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Supplier') ?>

                    <?= $form->field($model, 'tanggal_pembelian')->widget(\yii\jui\DatePicker::classname(), [

                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off']
                    ]) ?>


                    <?= $form->field($model, 'no_faktur')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?> </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    JS;
$this->registerJs($script);
?>
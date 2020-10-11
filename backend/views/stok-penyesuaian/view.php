<?php

use backend\models\DataBarang;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StokPenyesuaian */

$this->title = 'Data Penyesuaian Detail';
$this->params['breadcrumbs'][] = ['label' => 'Stok Penyesuaians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stok-penyesuaian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_stok_penyesuaian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_stok_penyesuaian], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <div class="row">
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-body">
                    <h3>Detail Stok Penyesuaian</h3>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_stok_penyesuaian',
                            'tanggal',
                            'keterangan:ntext',
                        ],
                    ]) ?>
                    <?php $form = ActiveForm::begin(['action' => ['stok-penyesuaian-detail/create']]); ?>

                    <?= $form->field($model_detail, 'id_stok_penyesuaian')->textInput(['value' => $model->id_stok_penyesuaian, 'type' => 'hidden'])->label(false) ?>

                    <?= $form->field($model_detail, 'id_barang')->widget(Select2::classname(), [
                        'data' => $data_barang,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Barang'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Barang') ?>

                    <?= $form->field($model_detail, 'qty')->textInput(['type' => 'number']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-body">
                    <h3>Data Stok Penyesuaian Detail</h3>
                    <table class="table" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th style="white-space: nowrap;">Aksi</th>
                                <th style="white-space: nowrap;">Nama Barang</th>
                                <th style="white-space: nowrap;">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($data_penyesuaian_detail as $key => $val) {
                                $barang = DataBarang::find()->where(['id_barang' => $val->id_barang])->one();
                                $no++;
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td></td>
                                    <td><?= $barang->nama_barang ?></td>
                                    <td><?= $val->qty ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
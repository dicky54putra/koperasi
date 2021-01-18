<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AnggotaKoperasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anggota Koperasi';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-koperasi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::button(
            '<i class="glyphicon glyphicon-plus"></i> Tambah Anggota',
            [
                'value' => Url::to(['create']),
                'title' => '', 'class' => 'showModalButton btn btn-success'
            ]
        );  ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Print Karu Anggota ALL', ['print-kartu-all'], ['class' => 'btn btn-default text-blue', 'target' => '_BLANK']) ?>
    </p>

    <?php
    //  GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'filterModel' => $searchModel,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],

    //          [
    //             'attribute' => 'kode_anggota', 
    //             'format' => 'raw', 
    //             'value'=> function($model){
    //                 return yii\helpers\Html::tag('div', '', ['id' => 'barcode-'.$model->kode_anggota]).
    //                 \barcode\barcode\BarcodeGenerator::widget([
    //                     'elementId' => 'barcode-'.$model->kode_anggota,
    //                     'value'=> $model->kode_anggota, 
    //                     'type'=>'ean13',
    //                 ]);
    //             },
    //         ],
    //         'nama_anggota',

    //         ['class' => 'yii\grid\ActionColumn'],
    //     ],
    // ]); 
    ?>

    <div class="box box-warning">
        <div class="box-header">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body" style="overflow-x: auto;">
                    <table class="table" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th>Aksi</th>
                                <th style="white-space: nowrap;">Kode</th>
                                <th style="white-space: nowrap;">Nama</th>
                                <!-- <th style="white-space: nowrap;">Jenis Anggota</th> -->
                                <th style="white-space: nowrap;">Npwp</th>
                                <th style="white-space: nowrap;">Kota</th>
                                <th style="white-space: nowrap;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($anggota as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?= Html::a('<button class = "btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>', ['view', 'id' => $value->id_anggota], [
                                            'title' => Yii::t('app', 'Lihat Detail'),
                                        ]); ?>
                                        <?= Html::button(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            [
                                                'value' => Url::to(['update', 'id' => $value->id_anggota]),
                                                'title' => 'Ubah data', 'class' => 'showModalButton  btn btn-sm btn-success'
                                            ]
                                        ); ?>
                                    </td>
                                    <td><?= $value->kode_anggota ?></td>
                                    <td><?= $value->nama_anggota ?></td>
                                    <!-- <td><?= $value->id_jenis_anggota == 1 ? 'Customer' : 'Supplier' ?></td> -->
                                    <td><?= $value->npwp ?></td>
                                    <td><?= $value->kota ?></td>
                                    <td>
                                        <?php if ($value->is_active == 1) {
                                            echo '<label class="label label-success">Aktif</label>';
                                        } else {
                                            echo '<label class="label label-danger">Tidak Aktif</label>';
                                        } ?>
                                    </td>
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
    </div>
</div>
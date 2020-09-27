<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Barang';
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="data-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::button(
            '<i class="glyphicon glyphicon-plus"></i> Tambah Data Barang',
            [
                'value' => Url::to(['create']),
                'title' => '', 'class' => 'showModalButton btn btn-success'
            ]
        );  ?>
    </p>

    <div class="box box-warning">
        <div class="box-header">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body" style="overflow-x: auto;">
                    <table class="table" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th style="white-space: nowrap;">Aksi</th>
                                <th style="white-space: nowrap;">Kode Barang</th>
                                <th style="white-space: nowrap;">Nama Barang</th>
                                <th style="white-space: nowrap;">Kategori</th>
                                <th style="white-space: nowrap;">Satuan</th>
                                <th style="white-space: nowrap;">Harga Jual</th>
                                <th style="white-space: nowrap;">Harga Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($data_barang as $key => $value) {
                            ?>

                                <tr>
                                    <td><?= $i++; ?>.</td>
                                    <td>
                                        <?= Html::a('<button class = "btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>', ['view', 'id' => $value->id_barang], [
                                            'title' => Yii::t('app', 'Lihat Detail'),
                                        ]); ?>
                                        <?= Html::button(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            [
                                                'value' => Url::to(['update', 'id' => $value->id_barang]),
                                                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-success'
                                            ]
                                        ); ?>
                                        <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_barang], [
                                            'title' => Yii::t('app', 'Hapus data'),
                                        ]); ?>
                                    </td>
                                    <td><?= $value->kode_barang ?></td>
                                    <td><?= $value->nama_barang ?></td>
                                    <td><?= $value->id_kategori ?></td>
                                    <td><?= $value->id_satuan ?></td>
                                    <td><?= $value->harga_jual ?></td>
                                    <td><?= $value->harga_beli ?></td>

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
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\KategoriBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategori Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::button(
            '<i class="glyphicon glyphicon-plus"></i> Tambah Data Kategori Barang',
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
                                <th style="white-space: nowrap;">Nama Kategori Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($data_kategori_barang as $key => $value) {
                            ?>

                                <tr>
                                    <td><?= $i++; ?>.</td>
                                    <td>
                                        <?= Html::button(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            [
                                                'value' => Url::to(['update', 'id' => $value->id_kategori]),
                                                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-success'
                                            ]
                                        ); ?>
                                        <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_kategori], [
                                            'title' => Yii::t('app', 'Hapus data'),
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]); ?>
                                    </td>
                                    <td><?= $value->nama_kategori ?></td>
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
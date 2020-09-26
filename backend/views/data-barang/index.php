<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Barang';
// $this->params['breadcrumbs'][] = $this->title;
$script = <<< JS


    $(document).ready(function(){

        $('#table-detail').DataTable();

    });


JS;

$this->registerJs($script);
?>
<div class="data-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
            <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Tambah Data Barang',
                    ['value' => Url::to(['create']),
                    'title' => '', 'class' => 'showModalButton btn btn-success']);  ?>
    </p>

    <div class="box">
        <div class="box-header">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body" style="overflow-x: auto;">
                    <table class="table" id="table-detail">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap;">#</th>
                                        <th style="min-width: 150px;">Aksi</th>
                                        <th style="min-width: 150px;">Kode Barang</th>
                                        <th style="min-width: 150px;">Nama Barang</th>
                                        <th style="white-space: nowrap;">Kategori</th>
                                        <th style="white-space: nowrap;">Satuan</th>
                                        <th style="min-width: 200px;">Harga Jual</th>
                                        <th style="min-width: 200px;">Harga Beli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 0;
                                        foreach ($data_barang as $key => $value) {
                                        $i++;
                                    ?>

                                        <tr>
                                            <td><?= $i ?>.</td>
                                            <td>.</td>
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


    


</div>

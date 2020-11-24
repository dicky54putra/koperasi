<?php

use yii\helpers\Html;

$this->title = 'Daftar Laporan';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <table class="table table-condensed">
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Penjualan', ['laporan/laporan-penjualan']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Pembelian', ['laporan/laporan-pembelian']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Stok Barang', ['laporan-stok-barang']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Stok Penyesuaian', ['laporan/laporan-stok-penyesuaian']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Laba Rugi', ['laporan/laporan-laba-rugi/']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
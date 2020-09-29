<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */
if ($model->jenis == 1 ){

    $this->title = 'Data Simpanan '.$model->anggota->nama_anggota;

} else {

    $this->title = 'Data Pinjaman '.$model->anggota->nama_anggota;

}
$this->params['breadcrumbs'][] = ['label' => 'Simpan Pinjams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simpan-pinjam-view">

    <h1><?= Html::encode($this->title) ?></h1>

     <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box box-warning">
        <div class="box-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id_simpan_pinjam',
                    [
                        'attribute' => 'id_anggota',
                        'label' => 'Nama Anggota',
                        'value' => function ($model) {
                            return $model->anggota->nama_anggota;
                        }
                    ],

                    [
                        'attribute' => 'jenis',
                        // 'label' => 'Tanggal penjualan',
                        'value' => function ($model) {
                            return $model->jenis == 1 ? 'Simpanan' : 'Pinjaman' ;
                        }
                    ],
                    [
                        'attribute' => 'tanggal',
                        // 'label' => 'Tanggal penjualan',
                        'value' => function ($model) {
                            return tanggal_indo($model->tanggal, true);
                        }
                    ],
                    [
                        'attribute' => 'nominal',
                        'format' => 'html',
                        'value' => function ($model) {
                            return '<b>Rp. '.number_format($model->nominal).'</b>';
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function ($model) {
                            return $model->status == 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>' ;
                        }
                    ],
                    'keterangan:ntext',
                ],
            ]) ?>
        </div>
    </div>

    <?php if ($model->jenis == 2) { ?>
    

        <div class="box box-warning">
            <div class="box-header"><h3 style="font-weight: bold;">History Pelunasan</h3></div>
                <div class="box-body">

                    <p>
                        <?= Html::button(
                            '<span class="glyphicon glyphicon-plus"></span> Tambah Data',
                            [
                                'value' => Url::to(['pelunasan/create', 'id' => $_GET['id']]),
                                'title' => 'Buat Data Pelunasan', 'class' => 'showModalButton btn btn-success'
                            ]
                        ); ?>
                    </p><br>

                    <table class="table" id="table-index">
                            <thead>
                                <tr>
                                    <th style="white-space: nowrap;">#</th>
                                    <th style="white-space: nowrap;">Aksi</th>
                                    <th style="white-space: nowrap;">Tanggal </th>
                                    <th style="white-space: nowrap;">Nominal</th>
                                    <th style="white-space: nowrap;">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $grandtotal = 0;
                                foreach ($data_pelunasan as $key => $value) {
                                    // $grandtotal += $value->total_jual;
                                ?>

                                    <tr>
                                       
                                        <td><?= $i++; ?>.</td>
                                        <td>
                                           
                                            <?= Html::button(
                                                '<span class="glyphicon glyphicon-edit"></span>',
                                                [
                                                    'value' => Url::to(['pelunasan/update', 'id' => $_GET['id'], 'id_lunas' => $value->id_pelunasan]),
                                                    'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-primary'
                                                ]
                                            ); ?>
                                            <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_pelunasan], [
                                                'title' => Yii::t('app', 'Hapus data'),
                                            ]); ?>
                                        </td>
                                        <td><?= tanggal_indo($value->tanggal, true) ?></td>
                                        <td><?= 'Rp. '.number_format($value->nominal) ?></td>
                                        <td align="center"><?= $value->catatan ?></td>

                                    </tr>

                                <?php }  ?>
                            </tbody>

                            <tfoot>
                                <!-- <tr style="background-color:#bdcfff">
                                    <td colspan="8"><b><i>GRANDTOTAL</i></b></td>
                                </tr> -->
                            </tfoot>
                        </table>

                
                </div>
        </div>
    <?php } ?>


</div>

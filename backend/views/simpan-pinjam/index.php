<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpanPinjamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Simpan Pinjam';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simpan-pinjam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-12" style="margin-top:20px;">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#simpanan"><span class="fa fa-bank"></span> Simpanan</a></li>
                        <li><a data-toggle="tab" href="#pinjaman"><span class="fa fa-credit-card"></span> Pinjaman</a></li>
                    </ul>
                <div class="tab-content">

                    <div id="simpanan" class="tab-pane fade in active" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <p>
                                    <?= Html::button(
                                        '<span class="glyphicon glyphicon-plus"></span> Tambah',
                                        [
                                            'value' => Url::to(['create-simpan']),
                                            'title' => 'Tambah data',
                                            'class' => 'showModalButton btn btn-primary'
                                        ]
                                    ); ?>
                                </p><br>

                                <table class="table datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aksi</th>
                                            <th>Tanggal Simpan</th>
                                            <th>Nama Anggota</th>
                                            <th>Pangkat</th>
                                            <th>Jenis</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i = 0;
                                            foreach ($data_simpan as $key => $value) {
                                            $i++;
                                        ?>

                                         <tr>
                                             <td><?= $i ?>.</td>
                                             <td style="white-space: nowrap;">
                                                 <?= Html::a('<button class = "btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>', ['view', 'id' => $value->id_simpan_pinjam], [
                                                        'title' => Yii::t('app', 'Lihat Detail'),
                                                    ]); ?>
                                                    <?= Html::button(
                                                        '<span class="glyphicon glyphicon-edit"></span>',
                                                        [
                                                            'value' => Url::to(['update-simpan', 'id' => $value->id_simpan_pinjam]),
                                                            'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-success'
                                                        ]
                                                    ); ?>
                                                    <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_simpan_pinjam], [
                                                        'title' => Yii::t('app', 'Hapus data'),
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to delete this item?',
                                                            'method' => 'post',
                                                        ],
                                                    ]); ?>
                                             </td>
                                             <td style="white-space: nowrap;"><?= tanggal_indo($value->tanggal, true) ?></td>
                                             <td style="white-space: nowrap;"><?= $value->anggota->nama_anggota ?></td>
                                             <td><?= $value->anggota->pangkat->nama_pangkat ?></td>
                                             <td><?= $value->jenis == 1 ? 'Simpanan' : 'Pinjaman' ?></td>
                                             <td><?= number_format($value->nominal) ?></td>
                                             <td><?= $value->keterangan ?></td>
                                             <td><?= $value->status == 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>' ?></td>

                                         </tr>
                                     <?php } ?>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr style="background-color:#bdcfff">
                                            <td colspan="6"><b><i>GRANDTOTAL</i></b></td>
                                            <td align="right"><b><i></i></b></td>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="pinjaman" class="tab-pane fade" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <p>
                                    <?= Html::button(
                                        '<span class="glyphicon glyphicon-plus"></span> Tambah',
                                        [
                                            'value' => Url::to(['create-pinjam']),
                                            'title' => 'Tambah data',
                                            'class' => 'showModalButton btn btn-primary'
                                        ]
                                    ); ?>
                                </p><br>
                                <table class="table datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aksi</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Nama Anggota</th>
                                            <th>Pangkat</th>
                                            <th>Jenis</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i = 0;
                                            foreach ($data_pinjam as $key => $value) {
                                            $i++;
                                        ?>

                                         <tr>
                                             <td><?= $i ?>.</td>
                                             <td style="white-space: nowrap;">
                                                 <?= Html::a('<button class = "btn btn-sm btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>', ['view', 'id' => $value->id_simpan_pinjam], [
                                                        'title' => Yii::t('app', 'Lihat Detail'),
                                                    ]); ?>
                                                    <?= Html::button(
                                                        '<span class="glyphicon glyphicon-edit"></span>',
                                                        [
                                                            'value' => Url::to(['update-pinjam', 'id' => $value->id_simpan_pinjam]),
                                                            'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-success'
                                                        ]
                                                    ); ?>
                                                    <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete', 'id' => $value->id_simpan_pinjam], [
                                                        'title' => Yii::t('app', 'Hapus data'),
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to delete this item?',
                                                            'method' => 'post',
                                                        ],
                                                    ]); ?>
                                             </td>
                                             <td style="white-space: nowrap;"><?= tanggal_indo($value->tanggal, true) ?></td>
                                             <td style="white-space: nowrap;"><?= $value->anggota->nama_anggota ?></td>
                                             <td><?= $value->anggota->pangkat->nama_pangkat ?></td>
                                             <td><?= $value->jenis == 1 ? 'Simpanan' : 'Pinjaman' ?></td>
                                             <td><?= number_format($value->nominal) ?></td>
                                             <td><?= $value->keterangan ?></td>
                                             <td><?= $value->status == 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>' ?></td>

                                         </tr>
                                     <?php } ?>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr style="background-color:#bdcfff">
                                            <td colspan="6"><b><i>GRANDTOTAL</i></b></td>
                                            <td align="right"><b><i></i></b></td>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

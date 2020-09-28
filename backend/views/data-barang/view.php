<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use backend\models\DataPembelianDetail;
use backend\models\DataPenjualanDetail;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */

$this->title = 'Detail Barang : ' . $model->nama_barang;
$this->params['breadcrumbs'][] = ['label' => 'Data Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::button(
            '<span class="glyphicon glyphicon-edit"></span> Ubah',
            [
                'value' => Url::to(['update', 'id' => $model->id_barang]),
                'title' => 'Ubah data',
                'class' => 'showModalButton btn btn-primary'
            ]
        ); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_barang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-warning">
        <!-- <div class="box-header">
            </div> -->
        <div class="box-body">
            <div class="col-md-6" style="padding: 0;">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'kategori_barang.nama_kategori',
                            'satuan.nama_satuan',
                            'kode_barang',
                            'nama_barang',
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6" style="padding: 0;">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id_anggota',
                                'label' => 'Supplier',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->anggota->nama_anggota;
                                }
                            ],
                            [
                                'attribute' => 'harga_jual',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return 'Rp. ' . ribuan($model->harga_jual) . ',-';
                                }
                            ],
                            [
                                'attribute' => 'harga_beli',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return 'Rp. ' . ribuan($model->harga_beli) . ',-';
                                }
                            ],
                            [
                                'attribute' => 'is_active',
                                'label' => 'Status',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->is_active == 1) {
                                        return '<label class="label label-success">Aktif</label>';
                                    } else {
                                        return '<label class="label label-danger">Tidak Aktif</label>';
                                    }
                                }
                            ]
                        ],
                    ]) ?>
                </div>
            </div>

            <div class="col-md-12" style="margin-top:20px;">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#stok-masuk"><span class="fa fa-truck-loading"></span> Stok Masuk</a></li>
                    <li><a data-toggle="tab" href="#stok-keluar"><span class="fa fa-truck-loading"></span> Stok Keluar</a></li>
                </ul>
                <div class="tab-content">

                    <div id="stok-masuk" class="tab-pane fade in active" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <p>
                                    <?= Html::button(
                                        '<span class="glyphicon glyphicon-plus"></span> Tambah',
                                        [
                                            'value' => Url::to(['stok-masuk/create', 'id' => $model->id_barang]),
                                            'title' => 'Tambah data',
                                            'class' => 'showModalButton btn btn-primary'
                                        ]
                                    ); ?>
                                </p>
                                <?php
                                $i = 0;
                                foreach ($stok_masuk as $key => $value) {
                                    $i++;
                                ?>
                                    <div class="panel">
                                        <div class="panel-heading" role="tab" id="heading<?= $i; ?>">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsemasuk<?php echo $i; ?>" aria-expanded="true" aria-controls="collapsemasuk<?= $i; ?>" class="drop">
                                                #<?php echo $i . ' : ' . tanggal_indo($value->tanggal_masuk) . ' || ' . $value->keterangan ?>
                                            </a>
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsemasuk<?php echo $i; ?>" aria-expanded="true" aria-controls="collapsemasuk<?= $i; ?>" style="float: right; margin-left:5px; transition: 0.5s;" class="btn btn-success drop btn-sm btn-flat">
                                                <span id="glyphicon" style="transition: 0.5s;" class="glyphicon glyphicon-chevron-down"></span>
                                            </a>
                                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-pembelian-penerimaan', 'id' => $value->id_stok_masuk], [
                                                'class' => 'btn btn-danger btn-sm btn-flat',
                                                'style' => [
                                                    'float' => 'right',
                                                ],
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                            <?= Html::button(
                                                '<span class="glyphicon glyphicon-edit"></span>',
                                                [
                                                    'value' => Url::to(['stok-masuk/update', 'id' => $value->id_stok_masuk]),
                                                    'title' => ' Terima Barang', 'class' => 'showModalButton btn btn-primary btn-sm btn-flat',
                                                    'style' => [
                                                        'float' => 'right'
                                                    ],
                                                ]
                                            ); ?>
                                        </div>
                                        <div id="collapsemasuk<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $i; ?>">
                                            <div class="panel-body">
                                                <table class="table datatables">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tanggal Pembelian</th>
                                                            <th>Qty</th>
                                                            <th>Diskon</th>
                                                            <th>harga</th>
                                                            <th>PPN</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $pembelian = DataPembelianDetail::find()
                                                            ->select(["data_pembelian_detail.*", "data_pembelian_barang.*"])->joinWith(['pembelian'])->where(['id_barang' => $model->id_barang])->andWhere(['id_stok_masuk' => $value->id_stok_masuk])->all();

                                                        $no = 0;
                                                        $sum_masuk = 0;
                                                        foreach ($pembelian as $key => $val) {
                                                            $no++;
                                                            $sum_masuk += $val->total_beli;
                                                        ?>
                                                            <tr>
                                                                <td><?= $no ?></td>
                                                                <td><?= tanggal_indo($val->pembelian->tanggal_pembelian) ?></td>
                                                                <td><?= $val->qty ?></td>
                                                                <td><?= $val->diskon ?></td>
                                                                <td><?= $val->harga_beli ?></td>
                                                                <td><?= $val->ppn ?></td>
                                                                <td align="right"><?= 'Rp. ' . number_format($val->total_beli) ?></td>
                                                            </tr>
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr style="background-color:#bdcfff">
                                                            <td colspan="6"><b><i>GRANDTOTAL</i></b></td>
                                                            <td align="right"><b><i><?php echo "Rp. " . number_format($sum_masuk) ?></i></b></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div id="stok-keluar" class="tab-pane fade" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <p>
                                    <?= Html::button(
                                        '<span class="glyphicon glyphicon-plus"></span> Tambah',
                                        [
                                            'value' => Url::to(['stok-keluar/create', 'id' => $model->id_barang]),
                                            'title' => 'Tambah data',
                                            'class' => 'showModalButton btn btn-primary'
                                        ]
                                    ); ?>
                                </p>

                                <?php
                                $i = 0;
                                foreach ($stok_keluar as $key => $value) {
                                    $i++;
                                ?>
                                    <div class="panel">
                                        <div class="panel-heading" role="tab" id="heading<?= $i; ?>">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsekeluar<?php echo $i; ?>" aria-expanded="true" aria-controls="collapsekeluar<?= $i; ?>" class="drop">
                                                #<?php echo $i . ' : ' . tanggal_indo($value->tanggal_keluar) . ' || ' . $value->keterangan ?>
                                            </a>
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsekeluar<?php echo $i; ?>" aria-expanded="true" aria-controls="collapsekeluar<?= $i; ?>" style="float: right; margin-left:5px; transition: 0.5s;" class="btn btn-success drop btn-sm btn-flat">
                                                <span id="glyphicon" style="transition: 0.5s;" class="glyphicon glyphicon-chevron-down"></span>
                                            </a>
                                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['stok-keluar/delete', 'id' => $value->id_stok_keluar], [
                                                'class' => 'btn btn-danger btn-sm btn-flat',
                                                'style' => [
                                                    'float' => 'right',
                                                ],
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                            <?= Html::button(
                                                '<span class="glyphicon glyphicon-edit"></span>',
                                                [
                                                    'value' => Url::to(['stok-keluar/update', 'id' => $value->id_stok_keluar]),
                                                    'title' => ' Terima Barang', 'class' => 'showModalButton btn btn-primary btn-sm btn-flat',
                                                    'style' => [
                                                        'float' => 'right'
                                                    ],
                                                ]
                                            ); ?>
                                        </div>
                                        <div id="collapsekeluar<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $i; ?>">
                                            <div class="panel-body">
                                                <table class="table datatables">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tanggal Penjualan</th>
                                                            <th>Qty</th>
                                                            <th>Diskon</th>
                                                            <th>harga</th>
                                                            <th>PPN</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $penjualan = DataPenjualanDetail::find()->joinWith(['penjualan'])->where(['id_barang' => $model->id_barang])->andWhere(['id_stok_keluar' => $value->id_stok_keluar])->all();

                                                        $no = 0;
                                                        $sum_masuk = 0;
                                                        foreach ($penjualan as $key => $val) {
                                                            $no++;
                                                            $sum_masuk += $val->total_jual;
                                                        ?>
                                                            <tr>
                                                                <td><?= $no ?></td>
                                                                <td><?= tanggal_indo($val->penjualan->tanggal_penjualan) ?></td>
                                                                <td><?= $val->qty ?></td>
                                                                <td><?= $val->diskon ?></td>
                                                                <td><?= $val->harga_jual ?></td>
                                                                <td><?= $val->ppn ?></td>
                                                                <td align="right"><?= 'Rp. ' . number_format($val->total_jual) ?></td>
                                                            </tr>
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr style="background-color:#bdcfff">
                                                            <td colspan="6"><b><i>GRANDTOTAL</i></b></td>
                                                            <td align="right"><b><i><?php echo "Rp. " . number_format($sum_masuk) ?></i></b></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
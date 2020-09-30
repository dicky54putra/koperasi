<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\models\PendaftaranPengujian;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Pinjaman Besar';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-view">

    <h4><?= Html::encode($this->title) ?></h4>

<div class="box">
    <div class="box-header">
        <div class="col-md-12" style="padding: 0;">
            <div class="box-body">
                <?= Html::beginForm(['laporan-hutang', array('class'=>'form-inline')]) ?>

                <table border="0" width="100%">
                    <tr>
                        <td width="10%">
                            <div class="form-group">Dari Tanggal</div>
                        </td>
                        <td align="center" width="5%">
                            <div class="form-group">:</div>
                        </td>
                        <td width="30%">
                            <div class="form-group">
                                <input type="date" name="tanggal_awal" class="form-control" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%">
                            <div class="form-group">Sampai Tanggal</div>
                        </td>
                        <td align="center" width="5%">
                            <div class="form-group">:</div>
                        </td>
                        <td width="30%">
                            <div class="form-group">
                                <input type="date" name="tanggal_akhir" class="form-control" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="form-group">
                              <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                <?php
                                if ($tanggal_awal != 0 && $tanggal_akhir != 0) {
                                    # code...
                                ?>
                                <?= Html::a('Export Laporan', ['export-excel-laporan-hutang', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
                                <?php
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>

                <?= Html::endForm() ?>
            </div>
            </div>
            </div>
            </div>

        <div class="box box-info" style="overflow: auto">
        <div class="col-md-12" style="padding: 0;">
            <div class="box-body">
                <p style="font-family: 'Times New Roman'"><h4>Periode : <?= ($tanggal_awal != '') ? date('d/m/Y', strtotime($tanggal_awal)) : '-' ; ?> Sampai <?= ($tanggal_akhir != '') ? date('d/m/Y', strtotime($tanggal_akhir)) : '-' ; ?></h4></p>
        
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anggota</th>
                                        <th>Tanggal Pinjaman</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $totalan_pengurangan = 0;
                                    $query1 = Yii::$app->db->createCommand("
                                        SELECT simpan_pinjam.id_anggota, simpan_pinjam.tanggal, simpan_pinjam.nominal, simpan_pinjam.keterangan, anggota_koperasi.nama_anggota
                                        FROM simpan_pinjam
                                        LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = simpan_pinjam.id_anggota
                                        WHERE simpan_pinjam.tanggal
                                        BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        AND simpan_pinjam.jenis = 2
                                        ORDER BY simpan_pinjam.tanggal
                                        ")->query();
                                    foreach ($query1 as $key => $data) {
                                        # code...
                                       
                                    ?>
                                    <tr>
                                        <td><?= $no++.'.' ?></td>
                                        <td><?= $data['nama_anggota'] ?></td>
                                        <td><?= tanggal_indo($data['tanggal'], true) ?></td>
                                        <td><?= 'Rp. '. ribuan($data['nominal']) ?></td>
                                        <td><?= $data['keterangan'] ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                         </table>
                        </div>
                    </div>
                </div>
    </div>

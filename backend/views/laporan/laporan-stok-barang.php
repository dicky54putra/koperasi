<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\models\StokMasuk;
use backend\models\StokKeluar;
use backend\models\DataPembelianDetail;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Stok Barang';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="invoice-view">

    <h4><?= Html::encode($this->title) ?></h4>

 <div class="box">
    <div class="box-header">
        <div class="col-md-12" style="padding: 0;">
            <div class="box-body">
                <?= Html::beginForm(['laporan-stok-barang', array('class'=>'form-inline')]) ?>

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
                                <?= Html::a('Export Laporan', ['export-excel-laporan-stok-barang', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
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
                 <p style="font-family: 'Times New Roman'"><h4>Periode Bulan: <?= ($tanggal_awal != '') ? tanggal_indo2(date('F', strtotime($tanggal_awal))) : '-' ; ?></h4></p>
        
                            <table class="table" id="table-index">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <!-- <th>Kategori</th> -->
                                        <!-- <th>Harga Jual</th> -->
                                        <th>Harga Beli</th>
                                        <th>Detail Stok Masuk</th>
                                        <th>Detail Stok Keluar</th>
                                        <th>Sisa Stok Sekarang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $totalan_pengurangan = 0;
                                    $tgl_masuk = '';
                                    $tgl_keluar = '';
                                    $qty_masuk = 0;
                                    $qty_keluar = 0;
                                    $query1 = Yii::$app->db->createCommand("
                                        SELECT data_barang.id_barang, data_barang.kode_barang, data_barang.nama_barang, kategori_barang.nama_kategori, data_barang.harga_jual, data_barang.harga_beli
                                        FROM data_barang
                                        LEFT JOIN data_satuan ON data_satuan.id_satuan = data_barang.id_satuan
                                        LEFT JOIN kategori_barang ON kategori_barang.id_kategori = data_barang.id_kategori
                                        ORDER BY data_barang.id_barang
                                        ")->query();
                                    foreach ($query1 as $key => $data) {
                                        # code...

                                        $total_stok = 0;
                                        $total_stok_kosong = '';



                                       $stok_masuk = Yii::$app->db->createCommand("
                                        SELECT total_qty
                                        FROM stok_masuk
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_masuk = '$tanggal_awal'
                                        ")->queryScalar();
                                       $stok_keluar = Yii::$app->db->createCommand("
                                        SELECT total_qty
                                        FROM stok_keluar
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_keluar = '$tanggal_awal'
                                        ")->queryScalar();
                                       // echo $stok_masuk;
                                       // die;
                                       // echo $total_stok_kosong;
                                       // $tgl_a = "";
                                       // foreach ($stok_masuk as $key => $value) {
                                       //     # code...
                                            
                                            

                                       //      $detail_beli = DataPembelianDetail::find()
                                       //              ->where(['id_barang' => $data['id_barang']])
                                       //              ->andWhere(['id_stok_masuk'=> $value->id_stok_masuk])
                                       //              ->all();
                                       //      $qty_in = 0 ;
                                       //      foreach ($detail_beli as $key => $equal) {
                                       //          # code...
                                       //          $qty_in .= $equal->qty;
                                       //      }

                                       //      $tgl_masuk .= '<b>'.tanggal_indo2(date('F', strtotime($value->tanggal_masuk))).' : <br></b>';


                                       //      $qty_masuk .= $value->total_qty;
                                       //      $tgl_a .= $value->tanggal_masuk;
                                       // }

                                       // $stok_keluar = StokKeluar::find()->where(['id_barang' => $data['id_barang']])->all();
                                       // $tgl_b = "";
                                       // foreach ($stok_keluar as $key => $value) {
                                       //     # code...
                                       //      $tgl_keluar .= tanggal_indo2(date('F', strtotime($value->tanggal_keluar))).'<br>';
                                       //      $qty_keluar .= $value->total_qty;
                                       //      $tgl_b = $value->tanggal_keluar;
                                       // }

                                       // $total_stok = $qty_masuk - $qty_keluar;
                                    ?>
                                    <tr> 
                                        <td><?= $no++.'.' ?></td>
                                        <!-- <td><?= $data['kode_barang']?></td> -->
                                        <td><?= $data['nama_barang'] ?></td>
                                        <td><?= 'Rp. '.number_format($data['harga_beli']) ?></td>
                                        <td><?= $stok_masuk ?></td>
                                        <td><?= $stok_keluar ?></td>

                                        <td><?= $stok_masuk-$stok_keluar ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                         </table>
                        </div>
                    </div>
                </div>
    </div>

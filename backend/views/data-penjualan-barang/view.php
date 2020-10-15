<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPenjualanBarang */

$this->title = 'Detail Penjualan';
$this->params['breadcrumbs'][] = ['label' => 'Data Penjualan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-penjualan-barang-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul> -->

    <!-- <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['penjualan-baru', 'id' => $model->id_penjualan], ['class' => 'btn btn-warning']) ?>
        <?= Html::button(
            '<span class="glyphicon glyphicon-edit"></span> Ubah',
            [
                'value' => Url::to(['update', 'id' => $model->id_penjualan]),
                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-primary'
            ]
        ); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penjualan], [
            'class' => 'tombol-hapus btn btn-danger',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 style="font-weight: bold;">History Penjualan
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penjualan], [
                            'class' => 'tombol-hapus btn btn-danger pull-right',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Transaksi Baru', ['penjualan-baru', 'id' => $model->id_penjualan], ['class' => 'btn btn-warning pull-right', 'style' => 'margin-right:5px;']) ?>
                    </h3>
                </div>
                <div class="box-body">
                    <?php
                    if ($model->jenis_pembayaran == null) {
                    ?>
                        <div class="row">
                            <div class="col-md-12" style="margin-top:20px;">
                                <ul class="nav nav-tabs" id="tabForRefreshPage">
                                    <li class="active"><a data-toggle="tab" href="#barcode"><span class="fa fa-barcode"></span> Cari Barcode</a></li>
                                    <li><a data-toggle="tab" href="#nama"><span class="fa fa-tags"></span> Cari Nama Barang</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="nama" class="tab-pane fade" style="margin-top:20px;">
                                        <?php $form = ActiveForm::begin(['action' => ['data-penjualan-barang/tambah-penjualan-detail'], 'options' => ['name' => 'TambahDetail']]); ?>
                                        <div class="col-md-8">
                                            <?= $form->field($model2, 'id_barang')->widget(Select2::classname(), [
                                                'data' => $data_barang,
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Pilih Barang'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Barang') ?>
                                            <?= $form->field($model2, 'id_penjualan')->textInput(['type' => 'hidden', 'value' => $model->id_penjualan])->label(false) ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right', 'style' => 'margin-top: 24px;']) ?>
                                        </div>

                                        <?php ActiveForm::end(); ?>
                                    </div>
                                    <div id="barcode" class="tab-pane fade in active" style="margin-top:20px;">
                                        <?php $form = ActiveForm::begin(['action' => ['data-penjualan-barang/tambah-penjualan-detail-barcode'], 'options' => ['id' => 'TambahDetailBarcode', 'name' => 'TambahDetailBarcode', 'class' => '']]); ?>
                                        <div class="col-md-8">
                                            <?= $form->field($model2, 'id_barang')->textInput(['autofocus' => true])->label('Barang') ?>
                                            <?= $form->field($model2, 'id_penjualan')->textInput(['type' => 'hidden', 'value' => $model->id_penjualan])->label(false) ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right hidden', 'style' => 'margin-top: 24px;']) ?>
                                        </div>

                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <br>
                    <!-- <div class="col-lg-12"> -->
                    <table class="table" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <?php if ($model->jenis_pembayaran == null) { ?>
                                    <th style="white-space: nowrap;">Aksi</th>
                                <?php } ?>
                                <th style="white-space: nowrap;">Keterangan Stok</th>
                                <th style="white-space: nowrap;">Nama Barang</th>
                                <th style="white-space: nowrap;">Harga</th>
                                <th style="white-space: nowrap;">Qty</th>
                                <th style="white-space: nowrap;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $grandtotal = 0;
                            foreach ($penjualan_detail as $key => $value) {
                                $grandtotal += $value->total_jual;
                            ?>

                                <tr>

                                    <td><?= $i++; ?>.</td>
                                    <?php if ($model->jenis_pembayaran == null) { ?>
                                        <td>
                                            <!-- <?= Html::button(
                                                        '<span class="glyphicon glyphicon-edit"></span>',
                                                        [
                                                            'value' => Url::to(['data-penjualan-detail/update', 'id' => $_GET['id'], 'id_detail' => $value->id_penjualan_detail]),
                                                            'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-primary'
                                                        ]
                                                    ); ?> -->
                                            <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete-penjualan-detail', 'id' => $value->id_penjualan_detail], [
                                                'title' => Yii::t('app', 'Hapus data'),
                                                'class' => 'tombol-hapus'
                                            ]); ?>
                                        </td>
                                    <?php } ?>
                                    <td><?= 'Bulan ' . tanggal_indo2(date('F', strtotime($value->stok_keluar->tanggal_keluar))) . ' - ' . $value->stok_keluar->keterangan ?></td>
                                    <td><?= $value->barang->nama_barang ?></td>
                                    <td><?= number_format($value->harga_jual) ?></td>
                                    <td align="center">
                                        <a href="#" style="cursor: pointer;" data-toggle="modal" data-target="#modal-view" data-id="<?= $value->id_penjualan_detail ?>" class="label label-default edit-qty"><?= $value->qty ?></a>
                                    </td>
                                    <td align="right"><?= number_format($value->total_jual) ?></td>

                                </tr>

                            <?php }  ?>
                        </tbody>

                        <tfoot>
                            <tr style="background-color:#bdcfff">
                                <?php if ($model->jenis_pembayaran == null) {
                                    $col = 6;
                                } else {
                                    $col = 5;
                                } ?>
                                <td colspan="<?= $col ?>"><b><i>GRANDTOTAL</i></b></td>
                                <td align="right"><b><i><?php echo "Rp. " . number_format($grandtotal) ?></i></b></td>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- </div> -->
                </div>


            </div>
        </div>
        <div class="col-md-4">
            <?php
            if ($model->jenis_pembayaran == null) {
            ?>
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="col-xs-6">
                            <button class="btn btn-primary form-control" id="pembayaran-tunai">Tunai</button>
                        </div>
                        <?php
                        if ($model->id_anggota > 0) {
                        ?>
                            <div class="col-xs-6">
                                <button class="btn btn-success form-control" id="pembayaran-tagihan">Tagihan</button>
                            </div>
                        <?php } ?>
                        <?= Html::beginForm(['data-penjualan-barang/cetak', 'id' => $_GET['id']], 'post') ?>
                        <div class="col-xs-12" style="float:right;margin-top: 10px;" id="form-tunai" hidden>
                            <div class="input-group mt-3">
                                <input class="form-control" type="number" id="bayar" name="bayar" placeholder="Input Pembayaran" aria-describedby="basic-addon1" />
                                <span class="input-group-btn" id="basic-addon1">
                                    <?= Html::submitButton('<span class="glyphicon glyphicon-print"></span> Cetak', ['class' => 'btn btn-warning pull-right']) ?>
                                </span>
                            </div>
                        </div>
                        <?= Html::endForm() ?>
                        <div class="col-xs-12" style="float:right;margin-top: 10px;" id="form-tagihan" hidden>
                            <?= Html::a('Cetak', ['cetak-tagihan', 'id' => $_GET['id']], ['class' => 'btn btn-warning form-control']) ?>
                            <!-- <a href="" class="btn btn-warning form-control">Cetak</a> -->
                        </div>
                    </div>
                </div>
            <?php
            } ?>
            <div class="box box-warning">
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="3" align="center" style="padding-bottom: 10px;"><b style="font-size: 11px;">KOPERASI SKADRON-31 <br> INVOICE</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="font-size: 11px;">No. Invoice</div>
                                </td>
                                <td colspan="2">
                                    <p style="font-size: 11px;">: <?= ($model->no_invoice != '') ? $model->no_invoice : '< no invoice >'; ?></p>
                                </td>
                            </tr>
                            <?php
                            if ($model->id_anggota > 0) {
                            ?>
                                <tr>
                                    <td>
                                        <div style="font-size: 11px;">Nama Anggota</div>
                                    </td>
                                    <td colspan="2">
                                        <p style="font-size: 11px;">: <?= $model->anggota->nama_anggota ?></p>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>
                                    <p style="font-size: 11px;">Tanggal</p>
                                </td>
                                <td colspan="2">
                                    <p style="font-size: 11px;">: <?= tanggal_indo($model->tanggal_penjualan, true) ?></p>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid black;">
                                <td style="padding-bottom: 12px;">
                                    <p style=" font-size: 11px;">Jam</p>
                                </td>
                                <td colspan="2" style="padding-bottom: 12px;">
                                    <p style="font-size: 11px;">: <?= date('H:i:s') ?></p>
                                </td>
                            </tr>
                            <?php
                            $i = 1;
                            $grandtotal = 0;
                            if (!empty($penjualan_detail)) {
                                foreach ($penjualan_detail as $key => $value) {
                                    $grandtotal += $value->total_jual;
                            ?>
                                    <tr>
                                        <td>
                                            <p style="font-size: 11px;"><?= $value->barang->nama_barang ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p style="font-size: 11px;float: right;"><?= $value->qty . ' x ' . $value->harga_jual  ?></p>
                                        </td>
                                        <td>
                                            <p style="font-size: 11px; text-align: right;">Rp. <?= number_format($value->total_jual)  ?></p>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td>
                                        <p style="font-size: 11px;"></p>
                                    </td>
                                    <td colspan="2">
                                        <p style="font-size: 11px; text-align: right;">Rp. </p>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td style="padding: 5px;"> </td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="font-size: 11px;">GRANDTOTAL</p>
                                </td>
                                <td colspan="2">
                                    <p style="font-size: 11px; text-align: right;"><?php echo "Rp. " . number_format($grandtotal) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="font-size: 11px;">PEMBAYARAN</p>
                                </td>
                                <td colspan="2">
                                    <p style="font-size: 11px; text-align: right;">
                                        <?= ($model->jumlah_bayar != null) ? 'Rp. ' . number_format($model->jumlah_bayar) : $retVal = ($model->jenis_pembayaran == 2) ? 'TAGIHAN' : '< pembayaran >'; ?>
                                    </p>
                                </td>
                            </tr>
                            <?php
                            if ($model->jenis_pembayaran == 1) {
                            ?>
                                <tr>
                                    <td>
                                        <p style="font-size: 11px;">KEMBALIAN</p>
                                    </td>
                                    <td colspan="2">
                                        <p style="font-size: 11px; text-align: right;">
                                            <?= 'Rp. ' . number_format($model->jumlah_bayar - $grandtotal) ?>
                                        </p>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3" style="padding-bottom: 12px;"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="border-top: 1px solid black;">
                                <td align="center" colspan="3" style="padding-top: 12px;">
                                    <p style="font-size: 11px;">.:TERIMA KASIH:.<br>Barang yang sudah dibeli <br>tidak dapat dikembalikan <br> ***</p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terima Barang Detail</h4>
            </div>
            <div class="modal-body">
                <?= Html::beginForm(['edit-qty', array('class' => 'form-inline')]) ?>
                <label for="qty">Qty</label>
                <input type="number" name="qty" id="qty" class="form-control" style="margin-bottom: 10px;" required>
                <input type="hidden" name="id_penjualan_detail" id="id_penjualan_detail" class="form-control" style="margin-bottom: 10px;">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<?php
$script = <<< JS
    $('#datapenjualandetail-id_barang').select2('open').select2('close');
    $('#pembayaran-tunai').click(function(){
        $('#form-tunai').removeAttr('hidden');
        $("#form-tagihan").attr("hidden",true);
    })
    $('#pembayaran-tagihan').click(function(){
        $('#form-tagihan').removeAttr('hidden');
        $("#form-tunai").attr("hidden",true);
    })
    $(".edit-qty").click(function() {
        // mengambil data berdasarkan id
        const id = $(this).data('id');
        console.log(id);
        // pindahin action
        $("#form").show();
        $('form').attr('action', 'index.php?r=data-penjualan-barang%2Fedit-qty&id='+id);
        $.ajax({
            url: 'index.php?r=data-penjualan-barang%2Fget-penjualan-detail&id='+id,
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id_penjualan_detail').val(data.id_penjualan_detail);
                $('#qty').focus();
                $('#qty').val(data.qty);
                // $('#stokpenyesuaian-keterangan').val(data.keterangan);
            }
        });
    });
    JS;
$this->registerJs($script);
?>
<!-- <script>
    document.onkeydown = function(teziger) {
        switch (teziger.keyCode) {
            case 48: // KeyCode tombol Enter
                // document.TambahDetail.submit();
                <?php
                foreach ($penjualan_detail as $key => $value) {
                }
                ?>
                break;
                // Menambah fungsi shortcut lain
            case 8: // KeyCode tombol backspace
                window.location = 'keluar.php';
                break;
        }
        // teziger.preventDefault(); // Menghapus fungsi default tombol
    }
</script> -->
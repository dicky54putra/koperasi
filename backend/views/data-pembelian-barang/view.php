<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPembelianBarang */

$this->title = 'Detail Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Data Pembelian Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-pembelian-barang-view">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 style="font-weight: bold;">History Pembelian
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pembelian], [
                            'class' => 'tombol-hapus btn btn-danger pull-right',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Transaksi Baru', ['index'], ['class' => 'btn btn-warning pull-right', 'style' => 'margin-right:5px;']) ?>
                    </h3>
                </div>
                <div class="box-body">
                    <?php
                    if ($model->tanggal_pembelian == date('Y-m-d')) {
                    ?>
                        <div class="row">
                            <?php $form = ActiveForm::begin(['action' => ['data-pembelian-barang/tambah-pembelian-detail']]); ?>
                            <div class="col-md-6">
                                <?= $form->field($model2, 'id_barang')->widget(Select2::classname(), [
                                    'data' => $data_barang,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Barang') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model2, 'qty')->textInput(['type' => 'number', 'value' => 1]) ?>
                                <?= $form->field($model2, 'id_pembelian')->textInput(['type' => 'hidden', 'value' => $model->id_pembelian])->label(false) ?>
                            </div>
                            <div class="col-md-3">
                                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right', 'style' => 'margin-top: 24px;']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    <?php } ?>
                    <br>
                    <table class="table" id="table-index">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <?php if ($model->tanggal_pembelian == date('Y-m-d')) { ?>
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
                            foreach ($pembelian_detail as $key => $value) {
                                $grandtotal += $value->total_beli;
                            ?>
                                <tr>
                                    <td><?= $i++; ?>.</td>
                                    <?php if ($model->tanggal_pembelian == date('Y-m-d')) { ?>
                                        <td>
                                            <!-- <?= Html::button(
                                                        '<span class="glyphicon glyphicon-edit"></span>',
                                                        [
                                                            'value' => Url::to(['data-pembelian-detail/update', 'id' => $_GET['id'], 'id_detail' => $value->id_pembelian_detail]),
                                                            'title' => 'Ubah data', 'class' => 'showModalButton btn btn-sm btn-primary'
                                                        ]
                                                    ); ?> -->
                                            <?= Html::a('<button class = "btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', ['delete-detail', 'id' => $value->id_pembelian_detail], [
                                                'title' => Yii::t('app', 'Hapus data'),
                                                'class' => 'tombol-hapus'
                                            ]); ?>
                                        </td>
                                    <?php } ?>
                                    <td><?= tanggal_indo($value->stok_masuk->tanggal_masuk, true) . ' - ' . $value->stok_masuk->keterangan ?></td>
                                    <td><?= (!empty($value->barang->nama_barang)) ? $value->barang->nama_barang : 'Barang tidak ada/ sudah dihapus'; ?></td>
                                    <td><?= number_format($value->harga_beli) ?></td>
                                    <td align="center"><?= $value->qty ?></td>
                                    <td align="right"><?= number_format($value->total_beli) ?></td>

                                </tr>

                            <?php } ?>
                        </tbody>

                        <tfoot>
                            <tr style="background-color:#bdcfff">
                                <?php if ($model->tanggal_pembelian == date('Y-m-d')) {
                                    $col = 6;
                                } else {
                                    $col = 5;
                                } ?>
                                <td colspan="<?= $col ?>"><b><i>GRANDTOTAL</i></b></td>
                                <td align="right"><b><i><?php echo "Rp. " . number_format($grandtotal) ?></i></b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-body">
                    <h3>Pembelian Barang</h3>
                    <br>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td style="white-space: nowrap;">Tanggal Pembelian</td>
                                <td style="white-space: nowrap;">:</td>
                                <td><?= tanggal_indo($model->tanggal_pembelian, true) ?></td>
                            </tr>
                            <tr>
                                <td>Supplier</td>
                                <td>:</td>
                                <td><?= $model->id_anggota == NULL ? '<i>Tidak ada Supplier</i>' : $retVal = (!empty($model->anggota->nama_anggota)) ? $model->anggota->nama_anggota : 'Supplier tidak ada/ sudah dihapus'; ?></td>
                            </tr>
                            <tr>
                                <td>No Faktur</td>
                                <td>:</td>
                                <td><?= $model->no_faktur ?></td>
                            </tr>
                            <tr>
                                <td>Grandtotal</td>
                                <td>:</td>
                                <td>Rp. <?= ribuan($grandtotal) ?>,-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    $('#datapembeliandetail-id_barang').select2('open').select2('close');
JS;
$this->registerJs($script);
?>
<?php

use backend\models\DataBarang;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StokPenyesuaianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stok Penyesuaian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-penyesuaian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="row">
        <div class="col-md-7">
            <div class="box box-warning">
                <div class="box-body">
                    <h3 style="margin-left: 10px;">Stok Penyesuaian
                        <!-- <?= Html::a('Cetak Stok Barang', ['cetak-stok-barang'], ['class' => 'btn btn-default', 'target' => '_BLANK']) ?> -->
                        &nbsp;
                        <?= Html::a('Ekspor Stok Barang', ['ekspor-stok-barang'], ['class' => 'btn btn-success']) ?></h3>
                    <table class="table datatables">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th style="white-space: nowrap;">Nama Barang</th>
                                <th style="white-space: nowrap;">Stok</th>
                                <th style="white-space: nowrap;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($data_barang as $key => $val) {
                                $no++;
                            ?>
                                <tr>
                                    <td>
                                        <?= $no ?>
                                    </td>
                                    <td>
                                        <?= $val->kode_barang . ' - ' . $val->nama_barang ?>
                                    </td>
                                    <td>
                                        <?= $val->stok ?>
                                    </td>
                                    <td>
                                        <Button class="btn btn-primary btn-sm edit" id="edit" data-id="<?= $val->id_barang ?>" style="z-index: 1;">Sesuaikan</Button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 style="margin-left: 10px;">Tambah Stok Penyesuaian</h3>
                </div>
                <div class="box-body" id="form">
                    <b id="judul-barang"></b>
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_barang')->textInput(['type' => 'hidden'])->label(false) ?>
                    <?= $form->field($model, 'qty')->textInput(['type' => 'number']) ?>
                    <?= $form->field($model, 'tipe')->radioList(array(1 => 'Penambahan', 2 => 'Pengurangan')); ?>
                    <?= $form->field($model, 'tanggal')->textInput() ?>
                    <?= $form->field($model, 'keterangan')->textarea() ?>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="box box-warning">
                <div class="box-body">
                    <h3>Riwayat Penyesuaian</h3>
                    <p>Tanggal <?= tanggal_indo(date('Y-m-d')) ?></p>
                    <table class="table display" id="pagination">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>qty</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($data_penyesuaian as $key => $val) {
                                $no++;
                                $barang = DataBarang::find()->where(['id_barang' => $val->id_barang])->one();
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= (!empty($barang->nama_barang)) ? $barang->nama_barang : "Barang tidak ada/ sudah dihapus" ?></td>
                                    <td><?= $val->qty ?></td>
                                    <td>
                                        <?= Html::a('Delete', ['delete', 'id' => $val->id_stok_penyesuaian], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    $("#form").hide();
    $(".edit").click(function() {
        // mengambil data berdasarkan id
        var id = $(this).data('id');
        console.log(id);
        // pindahin action
        $("#form").show();
        $('form').attr('action', 'index.php?r=stok-penyesuaian/create');
        $.ajax({
            url: 'index.php?r=stok-penyesuaian/get-barang&id='+id,
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                var d = new Date(),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
                if (month.length < 2) 
                month = '0' + month;
                if (day.length < 2) 
                day = '0' + day;
                var date = [year, month, day].join('-');
                console.log(date);
                $("#judul-barang").html(data.nama_barang);
                $('#stokpenyesuaian-id_barang').val(data.id_barang);
                $('#stokpenyesuaian-tanggal').val(date);
                $('#stokpenyesuaian-keterangan').val(data.keterangan);
            }
        });
    });
    JS;
$this->registerJs($script);
?>
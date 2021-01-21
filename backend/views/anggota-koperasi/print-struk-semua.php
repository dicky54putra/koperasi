<?php

use backend\models\DataBarang;
use yii\helpers\Html;
use backend\models\DataPenjualanDetail;

?>

<style>
    .table {
        /*border: solid 2px;*/
        border-collapse: collapse;
        /*text-transform: uppercase;*/
        /* line-height: 1; */
    }

    /*.td1 {
        margin-right: -5px;
    }*/

    .table td {
        /*padding-left: 11px;*/
        padding-right: 11px;
    }
</style>
<table class="table" border="1">
    <thead>
        <tr>
            <td colspan="6" align="center" style="padding-bottom: 10px;"><b style="font-size: 11px;">KOPERASI S-24/ADHIKA UTTAMAs<br> INVOICE</b></td>
        </tr>
        <tr>
            <td colspan="6" align="center"><?= $model->nama_anggota ?></td>
        </tr>
        <tr>
            <th>#</th>
            <th style="white-space: nowrap;">Tanggal</th>
            <th style="white-space: nowrap;">Nama Barang</th>
            <th style="white-space: nowrap;">Harga</th>
            <th style="white-space: nowrap;">Qty</th>
            <th style="white-space: nowrap;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $gt = 0;
        $tagihan = Yii::$app->db->createCommand("SELECT * FROM data_penjualan_detail LEFT JOIN data_penjualan_barang ON data_penjualan_barang.id_penjualan = data_penjualan_detail.id_penjualan WHERE data_penjualan_barang.id_anggota = '$model->id_anggota' AND data_penjualan_barang.jenis_pembayaran = '2'")->query();

        foreach ($tagihan as $key => $value) {
            $barang = DataBarang::find()->where(['id_barang' => $value['id_barang']])->one();
            $gt += $value['total_jual'];
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= (!empty($value['tanggal_penjualan'])) ? tanggal_indo($value['tanggal_penjualan']) : '' ?></td>
                <td><?= (!empty($barang->nama_barang)) ? $barang->nama_barang : 'Data barang tidak ada/ sudah dihapus' ?></td>
                <td><?= (!empty($barang->harga_jual)) ? 'Rp. ' . number_format($barang->harga_jual) : 'Data barang tidak ada/ sudah dihapus' ?></td>
                <td><?= $value['qty'] ?></td>
                <td><?= 'Rp. ' . number_format($value['total_jual']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5"></th>
            <th><?= 'Rp. ' . number_format($gt) ?></th>
        </tr>
    </tfoot>
</table>

<?php
$fileName = "Tagihan " . $model->nama_anggota . ".xls";
// $fileName = "Tagihan.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
<script>
    // window.print();
    var link = 'index.php?r=anggota-koperasi%2Fview&id=' + <?= $model->id_anggota ?>;
    console.log(link);
    setTimeout(window.location = link, 500);
</script>
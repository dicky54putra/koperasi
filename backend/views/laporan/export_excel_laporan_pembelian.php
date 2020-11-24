<?php

use backend\models\DataPembelianDetail;
use backend\models\DataPenjualanDetail;

$tanggal_awal = $_GET['tanggal_awal'];
$tanggal_akhir = $_GET['tanggal_akhir'];
?>
<style>
    table,
    td {
        border: 1px solid #000000;
    }

    table,
    th {
        border: 1px solid #000000;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 10px;
    }
</style>
<table class="table" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Supplier</th>
            <th>No. faktur</th>
            <th>Detail Barang (qty x harga satuan)</th>
            <th>Harga Total</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $totalan_pengurangan = 0;
        $grandtotal_ = 0;
        $barang = '';
        $hrg_barang = '';
        $diskon = '';
        $ppn = '';
        $query1 = Yii::$app->db->createCommand("
                                        SELECT data_pembelian_barang.id_pembelian, data_pembelian_barang.id_anggota, data_pembelian_barang.no_faktur, data_pembelian_barang.tanggal_pembelian, data_pembelian_barang.grandtotal, anggota_koperasi.nama_anggota
                                        FROM data_pembelian_detail
                                        LEFT JOIN data_pembelian_barang ON data_pembelian_barang.id_pembelian = data_pembelian_detail.id_pembelian
                                        LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = data_pembelian_barang.id_anggota
                                        WHERE data_pembelian_barang.tanggal_pembelian
                                        BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        GROUP BY data_pembelian_detail.id_pembelian
                                        ORDER BY data_pembelian_barang.tanggal_pembelian
                                        ")->query();
        foreach ($query1 as $key => $data) {
            $detail = DataPembelianDetail::find()->where(['id_pembelian' => $data['id_pembelian']])->all();
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= tanggal_indo($data['tanggal_pembelian'], true) ?></td>
                <td><?= (!empty($data['nama_anggota'])) ? $data['nama_anggota'] : 'Supplier tidak ditentukan'; ?></td>
                <td><?= (!empty($data['no_faktur'])) ? $data['no_faktur'] : 'No faktur tidak ditentukan'; ?></td>
                <td>
                    <?php
                    foreach ($detail as $key => $value) {
                        echo $barang = (!empty($value->barang->nama_barang)) ? $value->barang->nama_barang . ' ( ' . $value->qty . ' x ' . $value->harga_beli . ' ) <br>' : 'Barang tidak ada/ sudah dihapus'  . "<br>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $grandtotal = 0;
                    foreach ($detail as $key => $value) {
                        $hrg_barang = $value->total_beli;
                        echo number_format($value->total_beli) . '<br>';
                        $grandtotal += $hrg_barang;
                    }
                    ?>
                </td>
                <td><?= number_format($grandtotal) ?></td>
            </tr>
            <?php
            $grandtotal_ += $grandtotal;
            ?>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"><b>GRANDTOTAL</b></td>
            <td><?= number_format($grandtotal_) ?></td>
        </tr>
    </tfoot>
</table>
<?php
$fileName = "Report Excel Laporan Pembelian.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
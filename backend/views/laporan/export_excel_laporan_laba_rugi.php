<?php

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
    <tbody>
        <tr>
            <th colspan="11">Laporan Laba/Rugi Toko Pertanggal <?= tanggal_indo($tanggal_awal, true) ?> - <?= tanggal_indo($tanggal_akhir, true) ?></th>
        </tr>
        <tr>
            <th>Pendapatan</th>
            <th></th>
        </tr>
        <tr>
            <td>Pejualan Cash</td>
            <td align="right">
                <?php
                $pendapatan_cash =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 1 AND data_penjualan_barang.tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                echo ribuan($pendapatan_cash);
                ?>
            </td>
        </tr>
        <tr>
            <td>Pejualan Kredit</td>
            <td align="right">
                <?php
                $pendapatan_kredit =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 2 AND data_penjualan_barang.tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                echo ribuan($pendapatan_kredit);
                ?>
            </td>
        </tr>
        <tr>
            <td>Simpan</td>
            <td align="right">
                <?php
                $simpan =  Yii::$app->db->createCommand("SELECT SUM(nominal) FROM simpan_pinjam WHERE jenis = 1 AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                echo ribuan($simpan);
                ?>
            </td>
        </tr>
        <tr>
            <th>Total Pendapatan</th>
            <th align="right">
                <?php
                $total_pendapatan = $simpan + $pendapatan_cash + $pendapatan_kredit;
                echo ribuan($total_pendapatan);
                ?>
            </th>
        </tr>
        <tr>
            <th>Pengeluaran</th>
            <th></th>
        </tr>
        <tr>
            <td>Pembelian</td>
            <td align="right">
                <?php
                $pembelian =  Yii::$app->db->createCommand("SELECT SUM(total_beli) FROM data_pembelian_detail  INNER JOIN data_pembelian_barang ON data_pembelian_detail.id_pembelian = data_pembelian_barang.id_pembelian WHERE data_pembelian_barang.tanggal_pembelian BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                echo ribuan($pembelian);
                ?>
            </td>
        </tr>
        <tr>
            <td>Pinjaman</td>
            <td align="right">
                <?php
                $pinjam =  Yii::$app->db->createCommand("SELECT SUM(nominal) FROM simpan_pinjam WHERE jenis = 2 AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                echo ribuan($pinjam);
                ?>
            </td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <th align="right">
                <?php
                $total_pengeluaran = $pinjam + $pembelian;
                echo ribuan($total_pengeluaran);
                ?>
            </th>
        </tr>
        <tr>
            <th>Laba/Rugi</th>
            <th align="right">
                <?php
                $laba_rugi = $total_pendapatan - $total_pengeluaran;
                echo ribuan($laba_rugi);
                ?>
            </th>
        </tr>
    </tbody>
</table>
<?php
$fileName = "Report Excel Laporan Pinjaman Toko.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
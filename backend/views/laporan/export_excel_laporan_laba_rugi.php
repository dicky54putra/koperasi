<?php

use backend\models\DataBarang;
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
            <th colspan="2">Pendapatan</th>
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
            <td></td>
        </tr>
        <tr>
            <td>Pejualan Kredit</td>
            <td align="right">
                <?php
                $pendapatan_kredit =  Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail INNER JOIN data_penjualan_barang ON data_penjualan_detail.id_penjualan = data_penjualan_barang.id_penjualan WHERE jenis_pembayaran = 2 AND data_penjualan_barang.tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->queryScalar();
                echo ribuan($pendapatan_kredit);
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Barang Titipan</td>
            <td align="right">
                <?php
                $titipan =  Yii::$app->db->createCommand("SELECT * FROM stok_titipan WHERE  tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
                $jual = 0;
                $beli = 0;
                foreach ($titipan as $key => $value) {
                    $barang = DataBarang::find()->where(['id_barang' => $value['id_barang']])->one();
                    $beli += $barang->harga_beli * $value['qty'];
                    $jual += $barang->harga_jual * $value['qty'];
                    // echo $barang->harga_jual . '-' . $barang->harga_beli . '-' . $value['qty'] . '<br>';
                }
                $jumlah_titipan = $jual - $beli;
                echo ribuan($jumlah_titipan);
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th colspan="2">Total Pendapatan</th>
            <th style="border-top: 1px solid #000000;">
                <p style="float: right;">
                    <?php
                    $total_pendapatan = $jumlah_titipan + $pendapatan_cash + $pendapatan_kredit;
                    echo ribuan($total_pendapatan);
                    ?>
                </p>
            </th>
        </tr>
        <tr>
            <th colspan="2">Pengeluaran</th>
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
            <td></td>
        </tr>
        <tr>
            <th colspan="2">Total Pengeluaran</th>
            <th style="border-top: 1px solid #000000;">
                <p style="float: right;">
                    <?php
                    $total_pengeluaran = $pembelian;
                    echo ribuan($total_pengeluaran);
                    ?>
                </p>
            </th>
        </tr>
        <tr style="border-top: 1px solid #000000;">
            <th style="border-top: 1px solid #000000;" colspan="2">Laba/Rugi</th>
            <th style="border-top: 1px solid #000000;">
                <p style="float: right;">
                    <?php
                    $laba_rugi = $total_pendapatan - $total_pengeluaran;
                    echo ribuan($laba_rugi);
                    ?>
                </p>
            </th>
        </tr>
    </tbody>
</table>
<?php
$fileName = "Report Excel Laporan Pinjaman Toko.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
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
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal, Qty, & Keterangan</th>
            <th>Stok Sekarang</th>
        </tr>
    </thead>
    <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)) { ?>
        <tbody>
            <?php
            $no = 1;
            $totalan_pengurangan = 0;
            $tgl_masuk = '';
            $tgl_keluar = '';
            $qty_masuk = 0;
            $qty_keluar = 0;
            $query1 = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM stok_penyesuaian
                                        LEFT JOIN data_barang ON data_barang.id_barang = stok_penyesuaian.id_barang
                                        WHERE data_barang.tipe = 0
                                        AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        GROUP BY data_barang.id_barang
                                        ORDER BY data_barang.id_barang
                                        ")->query();
            foreach ($query1 as $key => $data) {
                $total_stok = 0;
                $total_stok_kosong = '';
                if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                    $stok_penyesuaian = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM stok_penyesuaian
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryAll();
                }
            ?>
                <tr>
                    <td><?= $no++ . '.' ?></td>
                    <td><?= $data['nama_barang'] ?></td>
                    <td>
                        <table style="width: 100%;">
                            <?php
                            if (!empty($stok_penyesuaian)) {
                                foreach ($stok_penyesuaian as $key => $val) {
                            ?>
                                    <tr>
                                        <td style="width: 35%;"><?= (!empty($val['tanggal'])) ? tanggal_indo($val['tanggal']) . ',' : ''; ?></td>
                                        <td style="width: 15%;"><?= ($val['tipe'] == 1) ? $val['qty'] . ',' : '(' . $val['qty'] . '),'; ?></td>
                                        <td><?= ($val['tipe'] == 1) ? ', ' . ribuan($val['qty'] * $data['harga_jual']) : ', (' . ribuan($val['qty'] * $data['harga_jual']) . ')'; ?></td>
                                        <!-- $val['keterangan'] -->
                                    </tr>
                                <?php  } ?>
                            <?php  } ?>
                        </table>
                    </td>
                    <td><?= $data['stok'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
</table>
<?php
$fileName = "Report Excel Laporan Stok Penyesuiaian Barang.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
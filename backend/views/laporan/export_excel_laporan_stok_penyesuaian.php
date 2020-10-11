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
            <td colspan="6">Periode Bulan: <?= ($tanggal_awal != '') ? tanggal_indo2(date('F', strtotime($tanggal_awal))) : '-'; ?></td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Stok Sekarang</th>
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
                                        SELECT *
                                        FROM stok_penyesuaian
                                        LEFT JOIN data_barang ON data_barang.id_barang = stok_penyesuaian.id_barang
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
                    <?php
                    if (!empty($stok_penyesuaian)) {
                        foreach ($stok_penyesuaian as $key => $val) {
                            echo ($val['tipe'] == 1) ? $val['qty'] . '<br>' : '(' . $val['qty'] . ')' . '<br>';
                        }
                    }
                    ?>
                </td>
                <td><?= $data['stok'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
$fileName = "Report Excel Laporan Stok Barang.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
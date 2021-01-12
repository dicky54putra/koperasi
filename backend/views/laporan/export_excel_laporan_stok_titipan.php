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
            <th>Laku</th>
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
                                        FROM stok_titipan
                                        LEFT JOIN data_barang ON data_barang.id_barang = stok_titipan.id_barang
                                        WHERE data_barang.tipe = 1
                                        AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        GROUP BY data_barang.id_barang
                                        ORDER BY data_barang.id_barang
                                        ")->query();
            foreach ($query1 as $key => $data) {
                $total_stok = 0;
                $total_stok_kosong = '';
                if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                    $stok_titipan = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM stok_titipan
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
                            $sum_diambil = 0;
                            $sum_setor = 0;
                            if (!empty($stok_titipan)) {
                                foreach ($stok_titipan as $key => $val) {
                                    if ($val['keterangan'] == 'diambil') {
                                        $jum_diambil = $val['qty'] * $data['harga_jual'];
                                        $sum_diambil += $jum_diambil;
                                        $jum_setor = 0;
                                        $sum_setor = 0;
                                    } else {
                                        $jum_diambil = 0;
                                        $sum_diambil = 0;
                                        $jum_setor = $val['qty'] * $data['harga_jual'];
                                        $sum_setor += $jum_setor;
                                    }

                            ?>
                                    <tr>
                                        <td style="width: 35%;"><?= (!empty($val['tanggal'])) ? tanggal_indo($val['tanggal']) . ',' : ''; ?></td>
                                        <td style="width: 15%;"><?= $val['qty']; ?></td>
                                        <td>
                                            <?= ($jum_diambil > 0) ? number_format($jum_diambil) : number_format($jum_setor); ?>
                                        </td>
                                        <td align="right"><?= $val['keterangan'] ?></td>
                                    </tr>
                                    <?php

                                    ?>
                                <?php  } ?>
                            <?php  } ?>
                        </table>
                    </td>
                    <td>
                        <?php
                        $diambil = Yii::$app->db->createCommand("SELECT * FROM stok_titipan LEFT JOIN data_barang ON data_barang.id_barang = stok_titipan.id_barang WHERE data_barang.tipe = 1 AND stok_titipan.keterangan = 'diambil' AND stok_titipan.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND data_barang.id_barang = $data[id_barang]")->queryAll();

                        $setor = Yii::$app->db->createCommand("SELECT * FROM stok_titipan LEFT JOIN data_barang ON data_barang.id_barang = stok_titipan.id_barang WHERE data_barang.tipe = 1 AND stok_titipan.keterangan != 'diambil' AND stok_titipan.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND data_barang.id_barang = $data[id_barang]")->queryAll();

                        $sum = 0;
                        $sum_ = 0;
                        $stok = 0;
                        $stok_ = 0;
                        foreach ($diambil as $key => $value) {
                            $jum = $value['qty'] * $value['harga_jual'];
                            $sum += $jum;
                            $stok += $value['qty'];
                        }
                        foreach ($setor as $key => $value) {
                            $jum_ = $value['qty'] * $value['harga_jual'];
                            $stok_ += $value['qty'];
                            $sum_ += $jum_;
                        }
                        echo $h_stok =  $stok_ - $stok;

                        ?>
                    </td>
                    <td><?= $data['stok'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
</table>
<?php
$fileName = "Report Excel Laporan Stok Barang Titipan.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
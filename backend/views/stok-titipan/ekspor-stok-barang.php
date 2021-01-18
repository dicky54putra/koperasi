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
<table class="table table-bordered" id="table-index">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Stok</th>
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
        // SELECT data_barang.id_barang, data_barang.kode_barang, data_barang.nama_barang, kategori_barang.nama_kategori, data_barang.harga_jual, data_barang.harga_beli, data_barang.stok
        $query1 = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM data_barang
                                        LEFT JOIN data_satuan ON data_satuan.id_satuan = data_barang.id_satuan
                                        LEFT JOIN kategori_barang ON kategori_barang.id_kategori = data_barang.id_kategori
                                        ORDER BY data_barang.id_barang
                                        ")->query();
        foreach ($query1 as $key => $data) {
            $total_stok = 0;
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= $data['kode_barang'] ?></td>
                <td><?= $data['nama_barang'] ?></td>
                <td><?= $data['stok'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
$fileName = "Report Excel Laporan Pinjaman Toko.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
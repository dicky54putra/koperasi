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
      <!-- <th>Kategori</th> -->
      <!-- <th>Harga Jual</th> -->
      <th>Harga Beli</th>
      <th>Detail Stok Masuk</th>
      <th>Detail Stok Keluar</th>
      <th>Sisa Stok Sekarang</th>
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
                                        SELECT data_barang.id_barang, data_barang.kode_barang, data_barang.nama_barang, kategori_barang.nama_kategori, data_barang.harga_jual, data_barang.harga_beli
                                        FROM data_barang
                                        LEFT JOIN data_satuan ON data_satuan.id_satuan = data_barang.id_satuan
                                        LEFT JOIN kategori_barang ON kategori_barang.id_kategori = data_barang.id_kategori
                                        ORDER BY data_barang.id_barang
                                        ")->query();
    foreach ($query1 as $key => $data) {
      $total_stok = 0;
      $total_stok_kosong = '';
      $stok_masuk = Yii::$app->db->createCommand("
                                        SELECT total_qty
                                        FROM stok_masuk
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_masuk BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryScalar();
      $stok_keluar = Yii::$app->db->createCommand("
                                        SELECT total_qty
                                        FROM stok_keluar
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryScalar();
    ?>
      <tr>
        <td><?= $no++ . '.' ?></td>
        <!-- <td><?= $data['kode_barang'] ?></td> -->
        <td><?= $data['nama_barang'] ?></td>
        <td><?= 'Rp. ' . number_format($data['harga_beli']) ?></td>
        <td><?= $stok_masuk ?></td>
        <td><?= $stok_keluar ?></td>

        <td><?= $stok_masuk - $stok_keluar ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>

  </tfoot>
</table>
<?php
$fileName = "Report Excel Laporan Stok Barang.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
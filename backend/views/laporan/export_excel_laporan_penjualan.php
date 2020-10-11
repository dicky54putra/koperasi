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
      <th colspan="11">Laporan Penjualan Pertanggal <?= tanggal_indo($tanggal_awal, true) ?> - <?= tanggal_indo($tanggal_akhir, true) ?></th>
    </tr>
    <tr>
      <th>No</th>
      <th>Tanggal Penjualan</th>
      <th>Nama Anggota</th>
      <th>No. Invoice</th>
      <th>Detail Barang (qty x harga satuan)</th>
      <th>Diskon</th>
      <th>Pajak</th>
      <th>Harga Total</th>
      <th>Status Pembayaran</th>
      <th>Grandtotal</th>
    </tr>

  </thead>
  <tbody>
    <?php
    $no = 1;
    $totalan_pengurangan = 0;
    $barang = '';
    $hrg_barang = '';
    $diskon = '';
    $ppn = '';
    $query1 = Yii::$app->db->createCommand("
                                        SELECT data_penjualan_barang.id_penjualan, data_penjualan_barang.id_anggota, data_penjualan_barang.no_invoice, data_penjualan_barang.tanggal_penjualan, data_penjualan_barang.grandtotal, data_penjualan_barang.jenis_pembayaran, anggota_koperasi.nama_anggota
                                        FROM data_penjualan_barang
                                        LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = data_penjualan_barang.id_anggota
                                        WHERE data_penjualan_barang.tanggal_penjualan
                                        BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        AND data_penjualan_barang.jenis_pembayaran in(1,2)
                                        ORDER BY data_penjualan_barang.tanggal_penjualan
                                        ")->query();
    foreach ($query1 as $key => $data) {
      $detail = DataPenjualanDetail::find()->where(['id_penjualan' => $data['id_penjualan']])->all();
    ?>
      <tr>
        <td><?= $no++ . '.' ?></td>
        <td><?= tanggal_indo($data['tanggal_penjualan'], true) ?></td>
        <td><?= $data['nama_anggota'] ?></td>
        <td><?= $data['no_invoice'] ?></td>
        <td>
          <?php
          foreach ($detail as $key => $value) {
            echo $barang = $value->barang->nama_barang . ' ( ' . $value->qty . ' x ' . $value->harga_jual . ' ) ' . "<br>";
          }
          ?>
        </td>
        <td>
          <?php
          foreach ($detail as $key => $value) {
            $diskon = $value->diskon;
            $diskon == 0 ? ' - <br>' : $diskon . '<br>';
          }
          ?>
        </td>
        <td>
          <?php
          foreach ($detail as $key => $value) {
            $ppn = $value->ppn;
            echo $ppn == 0 ? ' - <br>' : $ppn . '<br>';
          }
          ?>
        </td>
        <td>
          <?php
          $grandtotal = 0;
          foreach ($detail as $key => $value) {
            $hrg_barang = $value->total_jual;
            echo 'Rp. ' . number_format($value->total_jual) . '<br>';
            $grandtotal += $hrg_barang;
          }
          ?>
        </td>
        <td><?= $data['jenis_pembayaran'] == 1 ? 'LUNAS' : $retVal = ($data['jenis_pembayaran'] == 2) ? 'TAGIHAN' : 'Belum dikonfirmasi'; ?></td>
        <td><?= 'Rp. ' . ribuan($grandtotal) ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>

  </tfoot>
</table>
<?php
$fileName = "Report Excel Laporan Penjualan.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
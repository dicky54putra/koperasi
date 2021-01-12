<?php

use backend\models\DataPenjualanDetail;
use backend\models\StokPenyesuaian;

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
<table class="table table-bordered" border="1">
  <thead>
    <tr>
      <th rowspan="2">No</th>
      <th rowspan="2">Kode Barang</th>
      <th rowspan="2">Nama Barang</th>
      <th rowspan="2">Harga Beli</th>
      <th rowspan="2">Harga Jual</th>
      <th colspan="2" style="white-space: nowrap;">Persediaan Awal</th>
      <th colspan="2" style="white-space: nowrap;">Penjualan</th>
      <th colspan="2" style="white-space: nowrap;">Barang Masuk</th>
      <th colspan="2" style="white-space: nowrap;">Persediaan Akhir <small>(Dalam sistem pencatatan/ Nilai buku)</small></th>
      <th colspan="2" style="white-space: nowrap;">Persediaan DiGudang</th>
    </tr>
    <tr>
      <th>Qty</th>
      <th>Nominal</th>
      <th>Qty</th>
      <th>Nominal</th>
      <th>Qty</th>
      <th>Nominal</th>
      <th>Qty</th>
      <th>Nominal</th>
      <th>Qty</th>
      <th>Nominal</th>
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
      $gt_persediaan_stok = 0;
      $gt_persediaan_stok_digudang = 0;
      $gt_barang_masuk_stok = 0;
      $gt_penjualan_stok = 0;
      $gt_stok_penyesuaian = 0;
      $gt_persediaan_awal_stok = 0;
      $qty_keluar = 0;
      $query1 = Yii::$app->db->createCommand("
                                        SELECT *
                                        FROM data_barang
                                        LEFT JOIN data_satuan ON data_satuan.id_satuan = data_barang.id_satuan
                                        LEFT JOIN kategori_barang ON kategori_barang.id_kategori = data_barang.id_kategori
                                        WHERE data_barang.tipe = 0
                                        ORDER BY data_barang.id_barang
                                        ")->query();
      foreach ($query1 as $key => $data) {
        $gt_persediaan_stok += $data['stok'] * $data['harga_beli'];
        $gt_persediaan_stok_digudang += $data['stok'] * $data['harga_beli'];
        $total_stok = 0;
        $total_stok_kosong = '';
        $stok_masuk = Yii::$app->db->createCommand("
                                        SELECT SUM(qty)
                                        FROM data_pembelian_detail
                                        LEFT JOIN data_pembelian_barang ON data_pembelian_barang.id_pembelian = data_pembelian_detail.id_pembelian
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_pembelian BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryScalar();
        $stok_keluar = Yii::$app->db->createCommand("
                                        SELECT SUM(qty)
                                        FROM data_penjualan_detail
                                        LEFT JOIN data_penjualan_barang ON data_penjualan_barang.id_penjualan = data_penjualan_detail.id_penjualan
                                        WHERE id_barang = '$data[id_barang]'
                                        AND tanggal_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                        ")->queryScalar();
      ?>
        <tr>
          <td><?= $no++ . '.' ?></td>
          <td><?= $data['kode_barang'] ?></td>
          <td><?= $data['nama_barang'] ?></td>
          <td><?= number_format($data['harga_beli']) ?></td>
          <td><?= number_format($data['harga_jual']) ?></td>
          <?php
          $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->andWhere("tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->all();
          $jml = 0;
          $jml_ = 0;
          foreach ($stok_penyesuaian as $key => $val) {
            if ($val->tipe == 1) {
              $jml += $val['qty'];
            } else {
              $jml_ += $val['qty'];
            }
          }
          $jmll = $jml_ - $jml;
          ?>
          <td>
            <!-- qty persediaan awal -->
            <?php
            $stok_awal = $data['stok'] + $jmll + $stok_keluar - $stok_masuk;
            echo $stok_awal;
            ?>
          </td>
          <td>
            <!-- nominal persediaan awal -->
            <?= number_format($stok_awal *  $data['harga_beli']) ?>
          </td>
          <td>
            <!-- qty persediaan penjualan -->
            <?= (!empty($stok_keluar)) ? $stok_keluar : '-' ?>
          </td>
          <td>
            <!-- nominal persediaan penjualan -->
            <?= number_format($stok_barang_penjualan = $stok_keluar * $data['harga_jual']) ?>
          </td>
          <td>
            <!-- qty persediaan barang masuk -->
            <?= (!empty($stok_masuk)) ? $stok_masuk : '-' ?>
          </td>
          <td>
            <!-- nominal persediaan barang masuk -->
            <?= number_format($stok_barang_masuk = $stok_masuk * $data['harga_beli']) ?>
          </td>
          <td>
            <!-- qty persediaan akhir -->
            <?php
            $p_akhir = $stok_awal + $stok_masuk - $stok_keluar;
            echo $p_akhir;
            ?>
          </td>
          <td>
            <!-- nominal persediaan akhir -->
            <?= number_format($p_akhir * $data['harga_beli']) ?>
          </td>
          <td>
            <!-- qty persediaan gudang -->
            <?= $data['stok'] ?>
          </td>
          <td>
            <!-- nominal persediaan gudang -->
            <?= number_format($data['stok'] * $data['harga_beli']) ?>
          </td>
          <!-- <td>
                                        qty persediaan penyesuaian
                                        <?php
                                        $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->andWhere("tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->all();
                                        $jml = 0;
                                        $jml_ = 0;
                                        foreach ($stok_penyesuaian as $key => $val) {
                                          if ($val->tipe == 1) {
                                            $jml += $val['qty'];
                                            echo (!empty($val['qty'])) ? $val['qty'] . '<br>' : '-';
                                          } else {
                                            $jml_ += $val['qty'];
                                            echo (!empty($val['qty'])) ? '(' . $val['qty'] . ')' . '<br>' : '-';
                                          }
                                        }
                                        $jmll = $jml - $jml_;
                                        ?>
                                    </td>
                                    <td>
                                        nominal persediaan penyesuaian
                                    <?php
                                    $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->andWhere("tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->all();
                                    foreach ($stok_penyesuaian as $key => $val) {
                                      if ($val->tipe == 1) {
                                        echo number_format($val['qty'] *  $data['harga_jual']) . '<br>';
                                      } else {
                                        echo '(' . number_format($val['qty'] *  $data['harga_jual']) . ')<br>';
                                      }
                                    }
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                        $stok_penyesuaian = StokPenyesuaian::find()->where(['id_barang' => $data['id_barang']])->andWhere("tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->all();
                                        foreach ($stok_penyesuaian as $key => $val) {
                                          echo $val['keterangan'] . '<br>';
                                        }
                                        ?>
                                    </td> -->
        </tr>
        <?php
        $gt_barang_masuk_stok += $stok_barang_masuk;
        $gt_penjualan_stok += $stok_barang_penjualan;
        $gt_persediaan_awal_stok += $stok_barang_penjualan;
        ?>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="5"></th>
        <th>Total</th>
        <th><?= number_format($stok_awal *  $data['harga_beli']) ?></th>
        <th>Total</th>
        <th><?= number_format($gt_penjualan_stok) ?></th>
        <th>Total</th>
        <th><?= number_format($gt_barang_masuk_stok) ?></th>
        <th>Total</th>
        <th><?= number_format($gt_persediaan_stok) ?></th>
        <th>Total</th>
        <th><?= number_format($gt_persediaan_stok_digudang) ?></th>
      </tr>
    </tfoot>
  <?php } ?>
</table>
<?php
$fileName = "Report Excel Laporan Stok Barang.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
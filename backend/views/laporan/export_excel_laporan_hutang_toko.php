<?php
use backend\models\DataPenjualanDetail;

$tanggal_awal = $_GET['tanggal_awal'];
$tanggal_akhir = $_GET['tanggal_akhir'];
?>
<style>
table, td {  
  border: 1px solid #000000;
}
table, th {  
  border: 1px solid #000000;
}
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 10px;
}
</style>
<table class="table" border="1">
    <thead>
        <tr>
            <th colspan="11">Laporan Pinjaman Toko Pertanggal <?= tanggal_indo($tanggal_awal, true) ?> - <?= tanggal_indo($tanggal_akhir, true) ?></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Tanggal Pembelian</th>
            <th>Pembelian Detail</th>
            <th>Harga</th>
            <th>Grandtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $totalan_pengurangan = 0;
        $barang = '';
        $hrg_barang = '';
        $query1 = Yii::$app->db->createCommand("
            SELECT data_penjualan_barang.id_penjualan, data_penjualan_barang.id_anggota, data_penjualan_barang.tanggal_penjualan, data_penjualan_barang.grandtotal, anggota_koperasi.nama_anggota
            FROM data_penjualan_barang
            LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = data_penjualan_barang.id_anggota
            WHERE data_penjualan_barang.tanggal_penjualan
            BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            AND data_penjualan_barang.jenis_pembayaran = 2
            ORDER BY data_penjualan_barang.tanggal_penjualan
            ")->query();
        foreach ($query1 as $key => $data) {
            # code...
           $detail = DataPenjualanDetail::find()->where(['id_penjualan' => $data['id_penjualan']])->all();
           foreach ($detail as $key => $value) {
               # code...
                $barang .= $value->barang->nama_barang.' ( '.$value->qty.' ) '. "<br>";
                $hrg_barang .= 'Rp. '.number_format($value->harga_jual).'<br>';
           }
        ?>
        <tr>
            <td><?= $no++.'.' ?></td>
            <td><?= $data['nama_anggota'] ?></td>
            <td><?= tanggal_indo($data['tanggal_penjualan'], true) ?></td>
            <td><?= $barang ?></td>
            <td><?= $hrg_barang ?></td>
            <td><?= 'Rp. '. ribuan($data['grandtotal']) ?></td>
        </tr>      
         <?php } ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>
<?php
$fileName = "Report Excel Laporan Pinjaman Toko.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
<?php
// use backend\models\PendaftaranPengujian;

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
            <th colspan="11">Laporan Pinjaman Besar Pertanggal <?= tanggal_indo($tanggal_awal, true) ?> - <?= tanggal_indo($tanggal_akhir, true) ?></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Tanggal Pinjaman</th>
            <th>Nominal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $totalan_pengurangan = 0;
        $query1 = Yii::$app->db->createCommand("
            SELECT simpan_pinjam.id_anggota, simpan_pinjam.tanggal, simpan_pinjam.nominal, simpan_pinjam.keterangan, anggota_koperasi.nama_anggota
            FROM simpan_pinjam
            LEFT JOIN anggota_koperasi ON anggota_koperasi.id_anggota = simpan_pinjam.id_anggota
            WHERE simpan_pinjam.tanggal
            BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            AND simpan_pinjam.jenis = 2
            ORDER BY simpan_pinjam.tanggal
            ")->query();
        foreach ($query1 as $key => $data) {
            # code...
        ?>
        <tr>
            <td><?= $no++.'.' ?></td>
            <td><?= $data['nama_anggota'] ?></td>
            <td><?= tanggal_indo($data['tanggal'], true) ?></td>
            <td><?= 'Rp. '. ribuan($data['nominal']) ?></td>
            <td><?= $data['keterangan'] ?></td>
        </tr>       
         <?php } ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>
<?php
$fileName = "Report Excel Laporan Pinjaman Besar.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>
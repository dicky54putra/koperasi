<style>
    @import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended+Text&display=swap');

    .table {
        border: solid 2px;
        padding: 10px;
    }
</style>
<table class="table" width="400px">
    <thead>
        <tr>
            <td colspan="3" align="center">KARTU ANGGOTA KOPERASI SKUADRON 31</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="30%">NAMA</td>
            <td width="2%">:</td>
            <td><?= $model->nama_anggota ?></td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td><?= $model->alamat_anggota ?></td>
        </tr>
        <tr>
            <td>PANGKAT</td>
            <td>:</td>
            <td><?= (!empty($model->pangkat->nama_pangkat)) ? $model->pangkat->nama_pangkat : '' ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" align="center" style="font-family: 'Libre Barcode 39 Extended Text', cursive;font-size:2.5em;"><?= $model->kode_anggota ?></td>
        </tr>
    </tfoot>
</table>
<script>
    window.print();
</script>
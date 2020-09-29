<?php 

use yii\helpers\Html;

 ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended+Text&display=swap');

    .table {
        border: solid 2px;
        border-collapse: collapse;
        text-transform: uppercase;
    }

    tr.bottom_tr td {
      border-bottom: 3px solid black;
    }

    .table td{
        padding: 5px;
    }
</style>
<table class="table" width="400px">
    <thead>
        <tr class="bottom_tr">
            <td colspan="1" align="center" ><?php echo Html::img('@web/upload/logo31.jpg', ['class' => 'pull-left img-responsive', "width"=>"80px"]); ?></td>
            <td colspan="2" align="center" ><b>KARTU ANGGOTA KOPERASI SKUADRON 31</b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="30%"><br>Nama</td>
            <td width="2%"><br>:</td>
            <td><br><?= $model->nama_anggota ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?= $model->alamat_anggota ?></td>
        </tr>
        <tr>
            <td>Pangkat</td>
            <td>:</td>
            <td><?= (!empty($model->pangkat->nama_pangkat)) ? $model->pangkat->nama_pangkat : '' ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" align="center" style="font-family: 'Libre Barcode 39 Extended Text', cursive;font-size:3em;"><?= $model->kode_anggota ?></td>
        </tr>
    </tfoot>
</table>
<script>
    window.print();
</script>
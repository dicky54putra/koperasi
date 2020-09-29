<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use barcode\barcode\BarcodeGenerator as BarcodeGenerator;
?>

<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended+Text&display=swap'); */
    /* @import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap'); */
    /*@font-face {
        font-family: barcode;
        src: url(web/font/Code39-hoch-Logitogo.tff);
        font-weight: bold;
    }*/

    .table {
        border: solid 2px;
        border-collapse: collapse;
        text-transform: uppercase;
        /* line-height: 1; */
    }

    tr.bottom_tr td {
        /* background: rgba(0, 0, 0, 0.2); */
        border-bottom: 1px solid black;
        padding: 5px;
    }

    .table td {
        padding-left: 15px;
        padding-right: 15px;
    }
</style>
<table class="table" border="0" width="321px" height="207px">
    <thead>
        <tr class="bottom_tr">
            <td colspan="1" align="center"><?php echo Html::img('@web/upload/logo31.png', ['class' => 'pull-left img-responsive', "width" => "37px"]); ?></td>
            <td colspan="2" align="center"><b style="font-size: 15px;">KARTU ANGGOTA KOPERASI SKUADRON 31</b></td>
        </tr>
    </thead>
    <tbody>
        <tr height="40px" style="vertical-align: baseline; padding-top:50px">
            <td width="30%">
                <p style="font-size: 15px;">Nama</p>
            </td>
            <td width="2%">
                <p style="font-size: 15px;">:</p>
            </td>
            <td>
                <p style="font-size: 15px;"><?= $model->nama_anggota ?></p>
            </td>
        </tr>
        <tr height="12px">
            <td>
                <p style="font-size: 15px;">Alamat</p>
            </td>
            <td>
                <p style="font-size: 15px;">:</p>
            </td>
            <td>
                <p style="font-size: 15px;"><?= $model->alamat_anggota ?></p>
            </td>
        </tr>
        <tr height="40px" style="vertical-align: baseline;">
            <td>
                <p style="font-size: 15px;">Pangkat</p>
            </td>
            <td>
                <p style="font-size: 15px;">:</p>
            </td>
            <td>
                <p style="font-size: 15px;"><?= (!empty($model->pangkat->nama_pangkat)) ? $model->pangkat->nama_pangkat : '' ?></p>
            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3" style="font-size:45px;">
               
                <div id="showBarcode" style="align-content: center;">
                <?php echo BarcodeGenerator::widget([
                            'elementId'=> 'showBarcode', 
                            'value'=> $model->kode_anggota,
                            'type'=>'code39',
                            // 'options' => 'center',
                        ]);

                 ?>
           
                 </div>

            </td>
        </tr>
    </tfoot>
</table>



<?php 


echo BarcodeGenerator::widget([
    'elementId'=> 'showBarcode', 
    'value'=> $model->kode_anggota,
    'type'=>'code39'
]);

 ?>

<script>
    window.print();
</script>
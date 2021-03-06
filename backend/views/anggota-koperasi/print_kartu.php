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

    .table_ {
        border: solid 2px;
        border-collapse: collapse;
        text-transform: uppercase;
        width: 8cm;
        height: 3cm;
        /* line-height: 1; */
    }

    tr.bottom_tr td {
        /* background: rgba(0, 0, 0, 0.2); */
        border-bottom: 1px solid black;
        padding: 5px;
    }

    .table_ td {
        padding-left: 4px;
        padding-right: 0px;
    }
</style>
<table class="table_" border="0">
    <thead>
        <tr class="bottom_tr">
            <td align="center" colspan="2" style="width: 40px;"><?php echo Html::img('@web/upload/logo24.png', ['class' => ' img-responsive', "width" => "40px"]); ?></td>
            <td colspan="2" align="center"><b style="font-size: 15px;">KARTU ANGGOTA KOPERASI <br>S-24/ADHIKA UTTAMA</b></td>
            <td align="center" colspan="2" style="width: 40px;"><?php echo Html::img('@web/images/logo.png', ['class' => ' img-responsive', "width" => "40px"]); ?></td>
        </tr>
    </thead>
    <?php

    $panjang_nama = strlen($model->nama_anggota);

    if ($panjang_nama > 18) {
        $font_size = "12px";
        $vertical_align = "middle";
    } else {
        $vertical_align = "bottom";
        $font_size = "15px";
    }
    ?>
    <tbody>
        <tr height="7px" style="vertical-align: <?= $vertical_align ?>;">
            <td colspan="2">
                <p style="font-size: 15px;">Nama</p>
            </td>
            <td colspan="4" style="">
                <?php
                // $text = $model->nama_anggota;
                // $num_char = 10;
                // $char     = $text{
                //     $num_char - 1};
                // while ($char != ' ') {
                //     $char = $text{
                //         --$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
                // }
                // $tampil = substr($text, 0, $num_char) . '...';



                ?>
                <p style="font-size: <?= $font_size ?>;">: <?= $model->nama_anggota; ?></p>
            </td>
        </tr>
        <tr height="7px">
            <td colspan="2">
                <p style="font-size: 15px;">Alamat</p>
            </td>
            <td colspan="4">
                <p style="font-size: 15px;">: <?= $model->alamat_anggota ?></p>
            </td>
        </tr>
        <tr height="7px" style="vertical-align: baseline;">
            <td colspan="2">
                <p style="font-size: 15px;">Pangkat</p>
            </td>
            <td colspan="4">
                <p style="font-size: 15px;">: <?= (!empty($model->pangkat->nama_pangkat)) ? $model->pangkat->nama_pangkat : '' ?></p>
            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr height="10px" colspan="2">
            <td width="45px"></td>
            <td style="font-size:25px; padding-left: 20px;" colspan="2">
                <div id="<?= $model->kode_anggota ?>" style="align-content: center; width:20px;">
                    <?php echo BarcodeGenerator::widget([
                        'elementId' => $model->kode_anggota,
                        'value' => $model->kode_anggota,
                        'type' => 'code39',
                        // 'options' => 'center',
                    ]);
                    ?>
                </div>
            </td>
            <td width="25px" colspan="2"></td>
        </tr>
    </tfoot>
</table>




<?php
// echo BarcodeGenerator::widget([
//     'elementId' => 'showBarcode',
//     'value' => $model->kode_anggota,
//     'type' => 'code39'
// ]);
?>

<script>
    // window.print();
</script>
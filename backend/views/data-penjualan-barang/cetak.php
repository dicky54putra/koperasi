<?php

use yii\helpers\Html;
use backend\models\DataPenjualanDetail;

?>

<style>
    .table {
        /*border: solid 2px;*/
        border-collapse: collapse;
        /*text-transform: uppercase;*/
        /* line-height: 1; */
    }

    /*.td1 {
        margin-right: -5px;
    }*/

    .table td {
        /*padding-left: 11px;*/
        padding-right: 11px;
    }
</style>
<table class="table" width="15%">
    <thead>
        <tr>
            <td colspan="2" align="center" style="padding-bottom: 10px;"><b style="font-size: 11px;">KOPERASI SKADRON-31 <br> INVOICE</b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <p style="font-size: 11px;">No. Invoice</p>
            </td>
            <td>
                <p style="font-size: 11px;"><?= $model->no_invoice ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 11px;">Tanggal</p>
            </td>
            <td>
                <p style="font-size: 11px;">: <?= $model->tanggal_penjualan ?></p>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td style="padding-bottom: 12px;"">
                <p style="font-size: 11px;">Jam</p>
            </td>
            <td style="padding-bottom: 12px;">
                <p style="font-size: 11px;">: <?= date('H:i:s') ?></p>
            </td>
        </tr>
        <tr><td style="padding-top: 12px;"></td><td></td></tr>

        <?php 

            $data_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $_GET['id']])->all();
            $GD = 0;
            foreach ($data_detail as $key => $value) {
                # code...
            
                $GD += $value->total_jual;
         ?>
        
        <tr>
            <td>
                <p style="font-size: 11px;"><?= $value->barang->nama_barang ?></</p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 11px;"><?= $value->qty .' x '. $value->harga_jual  ?></p>
            </td>
            <td>
                <p style="font-size: 11px; text-align: right;">Rp. <?= number_format($value->total_jual)  ?></p>
            </td>

        </tr>

    <?php } ?>
        <tr><td style="padding: 5px;"><td></td></td></tr>

        <tr>
            <td>
                <p style="font-size: 11px;">GRANDTOTAL</p>
            </td>
            <td>
                <p style="font-size: 11px; text-align: right;">Rp. <?=  number_format($GD) ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 11px;">PEMBAYARAN</p>
            </td>

            <?php if ($model->jumlah_bayar == '') { ?>
            <td>
                <p style="font-size: 11px; text-align: right;">TAGIHAN</p>
            </td>
            <?php } else { ?>
            <td>
                <p style="font-size: 11px; text-align: right;">Rp. <?= number_format($model->jumlah_bayar)  ?></p>
            </td>
            <?php } ?>
        </tr>

        <?php if ($model->jumlah_bayar != '') { ?>

        <tr>
            <td>
                <p style="font-size: 11px;">KEMBALIAN</p>
            </td>
            <td>
                <p style="font-size: 11px; text-align: right;">Rp. <?= number_format($model->jumlah_bayar - $GD)  ?></p>
            </td>
        </tr>

        <?php } ?>

            

        <tr><td style="padding-bottom: 12px;"></td><td></td></tr>
    </tbody>

    <tfoot>
        <tr style="border-top: 1px solid black;">
            <td align="center" colspan="2" style="padding-top: 12px;">
                <p style="font-size: 11px;">.:TERIMA KASIH:.<br>Barang yang sudah dibeli <br>tidak dapat dikembalikan <br> ***</p>
            </td>
        </tr>
    </tfoot>
</table>





<script>
    window.print();
</script>
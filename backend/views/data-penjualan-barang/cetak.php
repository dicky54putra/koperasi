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
            <td colspan="3" align="center" style="padding-bottom: 10px;"><b style="font-size: 11px;">KOPERASI S - 24/ADHIKA UTTAMA<br> INVOICE</b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div style="font-size: 11px;">No. Invoice</div>
            </td>
            <td colspan="2">
                <p style="font-size: 11px;">: <?= ($model->no_invoice != '') ? $model->no_invoice : '< no invoice >'; ?></p>
            </td>
        </tr>
        <?php
        if ($model->id_anggota > 0) {
        ?>
            <tr>
                <td>
                    <div style="font-size: 11px;">Nama Anggota</div>
                </td>
                <td colspan="2">
                    <p style="font-size: 11px;">: <?= (!empty($model->anggota->nama_anggota)) ? $model->anggota->nama_anggota : 'Anggota tidak ada/ sudah dihapus' ?></p>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td>
                <p style="font-size: 11px;">Tanggal</p>
            </td>
            <td colspan="2">
                <p style="font-size: 11px;">: <?= tanggal_indo($model->tanggal_penjualan) ?></p>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td style="padding-bottom: 12px;">
                <p style=" font-size: 11px;">Jam</p>
            </td>
            <td colspan="2" style="padding-bottom: 12px;">
                <p style="font-size: 11px;">: <?= date('H:i:s') ?></p>
            </td>
        </tr>
        <?php
        $i = 1;
        $grandtotal = 0;
        if (!empty($penjualan_detail)) {
            foreach ($penjualan_detail as $key => $value) {
                $grandtotal += $value->total_jual;
        ?>
                <tr>
                    <td>
                        <p style="font-size: 11px;"><?= (!empty($value->barang->nama_barang)) ? $value->barang->nama_barang : 'Barang tidak ada/ sudah dihapus' ?>
                        </p>
                    </td>
                    <td>
                        <p style="font-size: 11px;float: right;"><?= $value->qty . ' x ' . $value->harga_jual  ?></p>
                    </td>
                    <td>
                        <p style="font-size: 11px; text-align: right;">Rp. <?= number_format($value->total_jual)  ?></p>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td>
                    <p style="font-size: 11px;"></p>
                </td>
                <td colspan="2">
                    <p style="font-size: 11px; text-align: right;">Rp. </p>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td style="padding: 5px;"> </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 11px;">GRANDTOTAL</p>
            </td>
            <td colspan="2">
                <p style="font-size: 11px; text-align: right;"><?php echo "Rp. " . number_format($grandtotal) ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 11px;">PEMBAYARAN</p>
            </td>
            <td colspan="2">
                <p style="font-size: 11px; text-align: right;">
                    <?= ($model->jumlah_bayar != null) ? 'Rp. ' . number_format($model->jumlah_bayar) : $retVal = ($model->jenis_pembayaran == 2) ? 'TAGIHAN' : '< pembayaran >'; ?>
                </p>
            </td>
        </tr>
        <?php
        if ($model->jenis_pembayaran == 1) {
        ?>
            <tr>
                <td>
                    <p style="font-size: 11px;">KEMBALIAN</p>
                </td>
                <td colspan="2">
                    <p style="font-size: 11px; text-align: right;">
                        <?= 'Rp. ' . number_format($model->jumlah_bayar - $grandtotal) ?>
                    </p>
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="3" style="padding-bottom: 12px;"></td>
        </tr>
    </tbody>
    <tfoot>
        <tr style="border-top: 1px solid black;">
            <td align="center" colspan="3" style="padding-top: 12px;">
                <p style="font-size: 11px;">.:TERIMA KASIH:.<br>Barang yang sudah dibeli <br>tidak dapat dikembalikan <br> ***</p>
            </td>
        </tr>
    </tfoot>
</table>





<script>
    window.print();
    // var link = 'index.php?r=data-penjualan-barang/view&id=' + <?= $model->id_penjualan ?>;
    // console.log(link);
    // setTimeout(window.location = link, 500);
</script>
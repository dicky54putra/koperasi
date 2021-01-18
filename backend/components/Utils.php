<?php

namespace yii\helpers;

use backend\models\AktJurnalUmumDetail;
use backend\models\MenuNavigasi;
use backend\models\MenuNavigasiRole;
use Yii;

class Utils

{
    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    public static function getNomorTransaksi($model, $kode, $select, $order)
    {


        $no_transaksi = '';
        $penyesuaian_kas = $model::find()->select([$select])->orderBy(" $order DESC")->limit(1)->one();
        if (!empty($penyesuaian_kas->$select)) {
            # code...
            $no_bulan = substr($penyesuaian_kas->$select, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($penyesuaian_kas->$select, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_transaksi = $kode . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_transaksi = $kode . date('ym') . '001';
            }
        } else {
            # code...
            $no_transaksi = $kode . date('ym') . '001';
        }

        return $no_transaksi;
    }

    public static function getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $in, $saldo_normal, $type)
    {

        $query_aktiva = AktJurnalUmumDetail::find()
            ->leftjoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
            ->leftjoin("akt_akun", "akt_akun.id_akun = akt_jurnal_umum_detail.id_akun")
            ->where("akt_jurnal_umum_detail.id_akun IN($in)")
            ->andWhere("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")
            ->andWhere("akt_akun.saldo_normal = '$saldo_normal'");

        $sum = $query_aktiva->sum($type);
        return $sum;
    }

    public static function RoleAccess()
    {
        // bahan
        $role = Yii::$app->db->createCommand("SELECT system_role.id_system_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id)->query();

        $id_role = '';
        foreach ($role as $role) {
            $id_role .= $role['id_system_role'] . ',';
        }
        $in_id_role = substr($id_role, 0, -1);
        $menu = Yii::$app->controller->id;

        $menu_navigasi = MenuNavigasi::find()->where(["url" => $menu])->one();

        $userAccess = MenuNavigasiRole::find()->where(["in", "id_system_role", $in_id_role])->andWhere(['id_menu' => $menu_navigasi->id_menu])->count();

        if ($userAccess < 1) {
            return Yii::$app->response->redirect(Url::to(['site/blocked']));
        }
    }
}

<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPangkat;
use backend\models\DataPangkatSearch;
use yii\helpers\ArrayHelper;
use backend\models\KategoriBarang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DataPangkatController implements the CRUD actions for DataPangkat model.
 */
class LaporanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all DataPangkat models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionLaporanHutang()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan-hutang', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanHutangToko()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan-hutang-toko', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanPiutangToko()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');
        $id_anggota  = Yii::$app->request->post('id_anggota');

        return $this->render('laporan-piutang-toko', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_anggota' => $id_anggota,
        ]);
    }

    public function actionLaporanPembelian()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');
        $id_anggota  = Yii::$app->request->post('id_anggota');

        return $this->render('laporan-pembelian', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_anggota' => $id_anggota,
        ]);
    }

    public function actionLaporanPenjualan()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');
        $id_anggota  = Yii::$app->request->post('id_anggota');
        $jenis_pembayaran  = Yii::$app->request->post('jenis_pembayaran');

        return $this->render('laporan-penjualan', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_anggota' => $id_anggota,
            'jenis_pembayaran' => $jenis_pembayaran,
        ]);
    }

    public function actionLaporanStokBarang()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');
        $kategori  = Yii::$app->request->post('kategori');

        $data = ArrayHelper::map(
            KategoriBarang::find()
                ->asArray()
                ->all(),
            'id_kategori',
            function ($model) {
                return $model['nama_kategori'];
            }
        );

        return $this->render('laporan-stok-barang', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kategori' => $kategori,
            'data' => $data,
        ]);
    }

    public function actionLaporanStokPenyesuaian()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan-stok-penyesuaian', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanStokTitipan()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan-stok-titipan', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanLabaRugi()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan-laba-rugi', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionExportExcelLaporanHutang()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_hutang', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionExportExcelLaporanHutangToko()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_hutang_toko', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionExportExcelLaporanPiutangToko($id_anggota = null)
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_piutang_toko', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_anggota' => $id_anggota,
        ]);
    }

    public function actionExportExcelLaporanPembelian($id_anggota = null)
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_pembelian', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_anggota' => $id_anggota,
        ]);
    }

    public function actionExportExcelLaporanPenjualan($id_anggota = null, $jenis_pembayaran = null)
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_penjualan', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_anggota' => $id_anggota,
            'jenis_pembayaran' => $jenis_pembayaran,
        ]);
    }

    public function actionExportExcelLaporanStokBarang($kategori = null)
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_stok_barang', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kategori' => $kategori,
        ]);
    }

    public function actionExportExcelLaporanStokTitipan()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_stok_titipan', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionExportExcelLaporanStokPenyesuaian()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_stok_penyesuaian', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionExportExcelLaporanLabaRugi()
    {
        $tanggal_awal   = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir  = Yii::$app->request->post('tanggal_akhir');

        return $this->renderPartial('export_excel_laporan_laba_rugi', [
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }
}

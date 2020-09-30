<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPangkat;
use backend\models\DataPangkatSearch;
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

}

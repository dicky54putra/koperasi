<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPenjualanDetail;
use backend\models\DataPenjualanDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use yii\helpers\ArrayHelper;

use backend\models\DataBarang;
use backend\models\StokKeluar;
use yii\helpers\Json;

/**
 * DataPenjualanDetailController implements the CRUD actions for DataPenjualanDetail model.
 */
class DataPenjualanDetailController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DataPenjualanDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataPenjualanDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataPenjualanDetail model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DataPenjualanDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new DataPenjualanDetail();

        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['nama_barang'];
            }
        );

        $data_stok_keluar = ArrayHelper::map(
            StokKeluar::find()->all(),
            'id_stok_keluar',
            function ($model) {
                return tanggal_indo($model['tanggal_keluar'], true) .' - '. $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash("success","Disimpan");
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data_barang' => $data_barang,
            'data_stok_keluar' => $data_stok_keluar,
        ]);
    }

    /**
     * Updates an existing DataPenjualanDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$id_detail)
    {
        $model = $this->findModel($id_detail);

        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['nama_barang'];
            }
        );

        $data_stok_keluar = ArrayHelper::map(
            StokKeluar::find()->all(),
            'id_stok_keluar',
            function ($model) {
                return tanggal_indo($model['tanggal_keluar'], true) .' - '. $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash("success","Disimpan");
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'data_barang' => $data_barang,
            'data_stok_keluar' => $data_stok_keluar,
        ]);
    }

    /**
     * Deletes an existing DataPenjualanDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DataPenjualanDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataPenjualanDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataPenjualanDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

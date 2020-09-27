<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPembelianDetail;
use backend\models\DataPembelianDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use backend\models\DataBarang;
use backend\models\StokMasuk;
use yii\helpers\Json;

/**
 * DataPembelianDetailController implements the CRUD actions for DataPembelianDetail model.
 */
class DataPembelianDetailController extends Controller
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
     * Lists all DataPembelianDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataPembelianDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataPembelianDetail model.
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
     * Creates a new DataPembelianDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new DataPembelianDetail();

        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['nama_barang'];
            }
        );

        $data_stok_masuk = ArrayHelper::map(
            StokMasuk::find()->all(),
            'id_stok_masuk',
            function ($model) {
                return tanggal_indo($model['tanggal_masuk'], true) .' - '. $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash("success","Data pembelian detail telah ditambahkan");
            return $this->redirect(['data-pembelian-barang/view', 'id' => $id]);


        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data_barang' => $data_barang,
            'data_stok_masuk' => $data_stok_masuk,
        ]);
    }

    /**
     * Updates an existing DataPembelianDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $id_detail)
    {
        $model = $this->findModel($id, $id_detail);

        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['nama_barang'];
            }
        );

        $data_stok_masuk = ArrayHelper::map(
            StokMasuk::find()->all(),
            'id_stok_masuk',
            function ($model) {
                return tanggal_indo($model['tanggal_masuk'], true) .' - '. $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['data-pembelian-barang/view', 'id' => $id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'data_barang' => $data_barang,
            'data_stok_masuk' => $data_stok_masuk,
        ]);
    }

    /**
     * Deletes an existing DataPembelianDetail model.
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
     * Finds the DataPembelianDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataPembelianDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataPembelianDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPembelianBarang;
use backend\models\DataPembelianBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AnggotaKoperasi;
use backend\models\DataPembelianDetail;

use yii\helpers\Json;

/**
 * DataPembelianBarangController implements the CRUD actions for DataPembelianBarang model.
 */
class DataPembelianBarangController extends Controller
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
     * Lists all DataPembelianBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataPembelianBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data_pembelian = DataPembelianBarang::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data_pembelian' => $data_pembelian,
        ]);
    }

    /**
     * Displays a single DataPembelianBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $pembelian_detail = DataPembelianDetail::find()->where(['id_pembelian' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'pembelian_detail' => $pembelian_detail,
        ]);
    }

    /**
     * Creates a new DataPembelianBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataPembelianBarang();

        $data_supplier = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 2])->all(),
            'id_anggota',
            function ($model) {
                return $model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data_supplier' => $data_supplier,
        ]);
    }

    /**
     * Updates an existing DataPembelianBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_supplier = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 2])->all(),
            'id_anggota',
            function ($model) {
                return $model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'data_supplier' => $data_supplier,
        ]);
    }

    /**
     * Deletes an existing DataPembelianBarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Dihapus');
        return $this->redirect(['index']);
    }

    /**
     * Finds the DataPembelianBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataPembelianBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataPembelianBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

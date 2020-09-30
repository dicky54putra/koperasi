<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPenjualanBarang;
use backend\models\DataPenjualanBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AnggotaKoperasi;
use backend\models\DataPenjualanDetail;
use yii\helpers\ArrayHelper;

use yii\helpers\Json;

/**
 * DataPenjualanBarangController implements the CRUD actions for DataPenjualanBarang model.
 */
class DataPenjualanBarangController extends Controller
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
     * Lists all DataPenjualanBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataPenjualanBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $data_penjualan = DataPenjualanBarang::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data_penjualan' => $data_penjualan,
        ]);
    }

    /**
     * Displays a single DataPenjualanBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'penjualan_detail' => $penjualan_detail,
        ]);
    }

    /**
     * Creates a new DataPenjualanBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataPenjualanBarang();

        $model->tanggal_penjualan = date('Y-m-d');


        $data_anggota = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->all(),
            'id_anggota',
            function ($model) {
                return $model['kode_anggota'] .' - '.$model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data_anggota' => $data_anggota,
        ]);
    }

    /**
     * Updates an existing DataPenjualanBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $data_anggota = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->all(),
            'id_anggota',
            function ($model) {
                return $model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'data_anggota' => $data_anggota,
        ]);
    }

    /**
     * Deletes an existing DataPenjualanBarang model.
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
     * Finds the DataPenjualanBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataPenjualanBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataPenjualanBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCetak($id)
    {
        $model = $this->findModel($id);

        $update = DataPenjualanBarang::findOne($id);

        // $bayar = Yii::$app->request->post('bayar');

        // echo $bayar;exit();

        if ($update->no_invoice == '') {
            
            $generate = DataPenjualanBarang::find()->count();
            $update->no_invoice = date('Ymd') . str_pad($generate + 1, 3, "0", STR_PAD_LEFT);
            $update->jumlah_bayar = Yii::$app->request->post('bayar');
            $update->save(false);

            return $this->redirect(['data-penjualan-barang/cetak', 'id' => $id]);
        }   



        return $this->renderPartial('cetak', [
            'model' => $model,
            // 'data_anggota' => $data_anggota,
        ]);
    }
}

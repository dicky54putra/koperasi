<?php

namespace backend\controllers;

use Yii;
use backend\models\DataBarang;
use backend\models\DataBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\models\KategoriBarang;
use backend\models\DataSatuan;
use backend\models\AnggotaKoperasi;
use backend\models\StokKeluar;
use backend\models\StokMasuk;
use yii\helpers\Json;

/**
 * DataBarangController implements the CRUD actions for DataBarang model.
 */
class DataBarangController extends Controller
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
     * Lists all DataBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data_barang = DataBarang::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data_barang' => $data_barang,
        ]);
    }

    /**
     * Displays a single DataBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $stok_masuk = StokMasuk::find()->where(['id_barang' => $id])->all();
        $stok_keluar = StokKeluar::find()->where(['id_barang' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'stok_masuk' => $stok_masuk,
            'stok_keluar' => $stok_keluar,
        ]);
    }

    /**
     * Creates a new DataBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataBarang();

        $data_kategori = ArrayHelper::map(
            KategoriBarang::find()->all(),
            'id_kategori',
            function ($model) {
                return $model['nama_kategori'];
            }
        );

        $data_satuan = ArrayHelper::map(
            DataSatuan::find()->all(),
            'id_satuan',
            function ($model) {
                return $model['nama_satuan'];
            }
        );

        $data_supplier = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 2])->all(),
            'id_anggota',
            function ($model) {
                return $model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'data_satuan' => $data_satuan,
            'data_kategori' => $data_kategori,
            'data_supplier' => $data_supplier,
        ]);
    }

    /**
     * Updates an existing DataBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_kategori = ArrayHelper::map(
            KategoriBarang::find()->all(),
            'id_kategori',
            function ($model) {
                return $model['nama_kategori'];
            }
        );

        $data_satuan = ArrayHelper::map(
            DataSatuan::find()->all(),
            'id_satuan',
            function ($model) {
                return $model['nama_satuan'];
            }
        );

        $data_supplier = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 2])->all(),
            'id_anggota',
            function ($model) {
                return $model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'data_satuan' => $data_satuan,
            'data_kategori' => $data_kategori,
            'data_supplier' => $data_supplier,
        ]);
    }

    /**
     * Deletes an existing DataBarang model.
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
     * Finds the DataBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

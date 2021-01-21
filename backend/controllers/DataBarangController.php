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
use yii\data\Pagination;
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
        $data_barang = DataBarang::find()->where(['tipe' => 0])->all();
        $data_barang_titipan = DataBarang::find()->where(['tipe' => 1])->all();
        $searchModel = new DataBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'data_barang' => $data_barang,
            'data_barang_titipan' => $data_barang_titipan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $query_masuk = StokMasuk::find()->where(['id_barang' => $id])->orderBy('id_stok_masuk DESC');
        // $countQuery = clone $query;
        $count_masuk = $query_masuk->count();
        $pages_masuk = new Pagination(['totalCount' => $count_masuk, 'pageSize' => 15]);
        $stok_masuk = $query_masuk->offset($pages_masuk->offset)
            ->limit($pages_masuk->limit)
            ->all();

        $query_keluar = StokKeluar::find()->where(['id_barang' => $id])->orderBy('id_stok_keluar DESC');
        // $countQuery = clone $query;
        $count_keluar = $query_keluar->count();
        $pages_keluar = new Pagination(['totalCount' => $count_keluar, 'pageSize' => 15]);
        $stok_keluar = $query_keluar->offset($pages_keluar->offset)
            ->limit($pages_keluar->limit)
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'stok_masuk' => $stok_masuk,
            'pages_masuk' => $pages_masuk,
            'stok_keluar' => $stok_keluar,
            'pages_keluar' => $pages_keluar,
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

    public function actionTambahBarangBanyak()
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

        $count = 0;
        if (Yii::$app->request->get()) {
            $count = Yii::$app->request->get('count');
        }
        if ($model->load(Yii::$app->request->post())) {
            if (sizeof(array_filter($_POST['DataBarang']['harga_jual'])) > 0) {
                foreach ($_POST['DataBarang']['harga_jual'] as $key => $row) {
                    // var_dump($model->harga_jual);
                    die;
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Disimpan');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('tambah-barang-banyak', [
            'model' => $model,
            'data_satuan' => $data_satuan,
            'data_kategori' => $data_kategori,
            'data_supplier' => $data_supplier,
            'count' => $count,
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

<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPembelianBarang;
use backend\models\StokMasuk;
use backend\models\DataPembelianBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AnggotaKoperasi;
use backend\models\DataBarang;
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
        $model = new DataPembelianBarangSearch();
        $model2 = new AnggotaKoperasi();

        $data_pembelian = DataPembelianBarang::find()->orderBy('id_pembelian DESC')->all();

        $data_supplier = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 2])->all(),
            'id_anggota',
            function ($model) {
                return $model['nama_anggota'];
            }
        );

        $model->tanggal_pembelian = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('index', [
            'model' => $model,
            'model2' => $model2,
            'data_pembelian' => $data_pembelian,
            'data_supplier' => $data_supplier,
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
        $model2 = new DataPembelianDetail();
        $pembelian_detail = DataPembelianDetail::find()->where(['id_pembelian' => $id])->all();
        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['kode_barang'] . ' - ' . $model['nama_barang'] . ' - ' . $model['stok'];
            }
        );

        return $this->render('view', [
            'model' => $this->findModel($id),
            'model2' => $model2,
            'data_barang' => $data_barang,
            'pembelian_detail' => $pembelian_detail,
        ]);
    }

    public function actionTambahPembelianDetail()
    {
        $model = new DataPembelianDetail();
        if ($model->load(Yii::$app->request->post())) {
            $id = $model->id_pembelian;
            $cek_stok_masuk = StokMasuk::find()->where('YEAR(tanggal_masuk) = ' . date('Y'))->andWhere('MONTH(tanggal_masuk) = ' . date('m'))->andWhere(['id_barang' => $model->id_barang])->count();

            $barang = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();

            if ($cek_stok_masuk == 0) {
                # insert
                $stok_masuk_tambah = new StokMasuk();
                $stok_masuk_tambah->id_barang = $model->id_barang;
                $stok_masuk_tambah->tanggal_masuk = date('Y-m-d');
                $stok_masuk_tambah->total_qty = $model->qty;
                $stok_masuk_tambah->save(false);
                $model->id_stok_masuk = $stok_masuk_tambah->id_stok_masuk;
            } else {
                # update
                $stok_masuk_ubah = StokMasuk::find()
                    ->where('YEAR(tanggal_masuk) = ' . date('Y'))->andWhere('MONTH(tanggal_masuk) = ' . date('m'))
                    ->andWhere(['id_barang' => $model->id_barang])
                    ->one();
                $stok_masuk_ubah->total_qty = $stok_masuk_ubah->total_qty + $model->qty;
                $stok_masuk_ubah->save(false);
                $model->id_stok_masuk = $stok_masuk_ubah->id_stok_masuk;
            }

            $barang->stok = $barang->stok + $model->qty;
            $barang->save(false);

            $model->harga_beli = $barang->harga_beli;
            $model->total_beli = $model->harga_beli * $model->qty;
            $model->save(false);

            $pembelian_detail = DataPembelianDetail::find()->where(['id_pembelian' => $id])->all();
            $grandtotal = 0;
            foreach ($pembelian_detail as $key => $value) {
                $grandtotal += $value->total_beli;
            }

            $pembelian = DataPembelianBarang::find()->where(['id_pembelian' => $id])->one();
            $pembelian->grandtotal = $grandtotal;
            $pembelian->save(false);
            Yii::$app->session->setFlash("success", "Disimpan");
            return $this->redirect(['data-pembelian-barang/view', 'id' => $id]);
        }
    }

    public function actionDeleteDetail($id)
    {
        $model = DataPembelianDetail::find()->where(['id_pembelian_detail' => $id])->one();
        $barang = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();
        $stok_masuk = StokMasuk::find()->where(['id_stok_masuk' => $model->id_stok_masuk])->one();

        $barang->stok = $barang->stok - $model->qty;
        $stok_masuk->total_qty = $stok_masuk->total_qty - $model->qty;

        $barang->save(false);
        $stok_masuk->save(false);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Dihapus');
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    /**
     * Creates a new DataPembelianBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataPembelianBarang();
        $model2 = new AnggotaKoperasi();

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
            'model2' => $model2,
            'data_supplier' => $data_supplier,
        ]);
    }

    public function actionCreateStok($id)
    {
        // echo $id;
        // die;
        $model = new StokMasuk();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // $pembelian_detail = DataPembelianDetail::find()->where(['id_pembelian' => $id])->all();
            // $grandtotal = 0;
            // foreach ($pembelian_detail as $key => $value) {
            //     $grandtotal += $value->total_beli;
            // }

            // $pembelian = DataPembelianBarang::find()->where(['id_pembelian' => $id])->one();
            // $pembelian->grandtotal = $grandtotal;
            // $pembelian->save(false);

            Yii::$app->session->setFlash("success", "Disimpan");
            return $this->redirect(['data-pembelian-barang/view', 'id' => $id]);
        }
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
        $model2 = new AnggotaKoperasi();

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
            'model2' => $model2,
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
        $model = $this->findModel($id);
        $model_detail = DataPembelianDetail::find()->where(['id_pembelian' => $id])->all();

        foreach ($model_detail as $key => $val) {
            $barang = DataBarang::find()->where(['id_barang' => $val->id_barang])->one();
            $stok_masuk = StokMasuk::find()->where(['id_stok_masuk' => $val->id_stok_masuk])->one();

            $barang->stok = $barang->stok - $val->qty;
            $stok_masuk->total_qty = $stok_masuk->total_qty - $val->qty;

            $barang->save(false);
            $stok_masuk->save(false);
        }

        DataPembelianDetail::deleteAll(['id_pembelian' => $id]);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Dihapus');
        return $this->redirect(['index']);
    }

    public function actionCreateAnggota()
    {
        $model = new AnggotaKoperasi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }
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

<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPenjualanBarang;
use backend\models\DataBarang;
use backend\models\StokKeluar;
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
        $model = new DataPenjualanBarang();
        $searchModel = new DataPenjualanBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data_anggota_ = ArrayHelper::map(
            AnggotaKoperasi::find()->where('id_jenis_anggota != 2')->all(),
            'kode_anggota',
            function ($model) {
                return $model['kode_anggota'] . ' - ' . $model['nama_anggota'];
            }
        );
        $data_anggota = AnggotaKoperasi::find()->select(["CONCAT(kode_anggota) as value", "id_anggota as id"])->where('id_jenis_anggota != 2')->asArray()->all();


        $data_penjualan = DataPenjualanBarang::find()->orderBy('id_penjualan DESC')->all();

        if ($model->load(Yii::$app->request->post())) {
            $cek_anggota = AnggotaKoperasi::find()->where(['kode_anggota' => $model->id_anggota])->one();
            if (!empty($cek_anggota->nama_anggota)) {
                $model->id_anggota = $cek_anggota->id_anggota;
            } else {
                Yii::$app->session->setFlash('error', 'Kode Anggota Belum Terdaftar');
                return $this->redirect(['index']);
            }
            // var_dump($model->id_anggota);
            // die;
            $model->tanggal_penjualan = date('Y-m-d');
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'model' => $model,
            'dataProvider' => $dataProvider,
            'data_penjualan' => $data_penjualan,
            'data_anggota' => $data_anggota,
            'data_anggota_' => $data_anggota_,
        ]);
    }

    public function actionPenjualanBaru($id)
    {
        $cek = DataPenjualanBarang::find()->where(['id_penjualan' => $id])->one();
        // var_dump($cek->jenis_pembayaran);
        // die;
        if ($cek->jenis_pembayaran == null) {
            $cek->delete();
            // Yii::$app->session->setFlash('success', 'Dihapus');
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['index']);
        }
    }
    public function actionPenjualanUmum()
    {
        $model = new DataPenjualanBarang();
        $model->tanggal_penjualan = date('Y-m-d');
        $model->id_anggota = 0;
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Disimpan');
        return $this->redirect(['view', 'id' => $model->id_penjualan]);
    }

    /**
     * Displays a single DataPenjualanBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model2 = new DataPenjualanDetail();
        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();
        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['kode_barang'] . ' - ' . $model['nama_barang'] . ' - ' . $model['stok'];
            }
        );

        return $this->render('view', [
            'model' => $this->findModel($id),
            'penjualan_detail' => $penjualan_detail,
            'data_barang' => $data_barang,
            'model2' => $model2,
        ]);
    }

    public function actionTambahPenjualanDetail()
    {
        $model = new DataPenjualanDetail();
        if ($model->load(Yii::$app->request->post())) {
            $id = $model->id_penjualan;
            $model->qty = 1;
            $cek_stok_keluar = StokKeluar::find()->where('YEAR(tanggal_keluar) = ' . date('Y'))->andWhere('MONTH(tanggal_keluar) = ' . date('m'))->andWhere(['id_barang' => $model->id_barang])->count();

            $cek_harga = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();

            if ($model->qty > $cek_harga->stok) {
                Yii::$app->session->setFlash("error", "Stok Barang tidak mencukupi");
            } else {
                if ($cek_stok_keluar == 0) {
                    # insert
                    $stok_keluar_tambah = new StokKeluar();
                    $stok_keluar_tambah->id_barang = $model->id_barang;
                    $stok_keluar_tambah->tanggal_keluar = date('Y-m-d');
                    $stok_keluar_tambah->total_qty = $model->qty;
                    $stok_keluar_tambah->save(false);
                    $model->id_stok_keluar = $stok_keluar_tambah->id_stok_keluar;
                } else {
                    # update
                    $stok_keluar_ubah = StokKeluar::find()
                        ->where('YEAR(tanggal_keluar) = ' . date('Y'))->andWhere('MONTH(tanggal_keluar) = ' . date('m'))
                        ->andWhere(['id_barang' => $model->id_barang])
                        ->one();
                    $stok_keluar_ubah->total_qty = $stok_keluar_ubah->total_qty + $model->qty;
                    // var_dump($stok_keluar_ubah->total_qty);
                    // die;
                    $stok_keluar_ubah->save(false);
                    $model->id_stok_keluar = $stok_keluar_ubah->id_stok_keluar;
                }

                $model->harga_jual = $cek_harga->harga_jual;
                $model->total_jual = $model->harga_jual * $model->qty;

                $penjualan_detail = DataPenjualanDetail::find()->where(['id_barang' => $model->id_barang])->andWhere(['id_penjualan' => $model->id_penjualan])->one();
                if (!empty($penjualan_detail->id_penjualan_detail)) {
                    $penjualan_detail->qty = $penjualan_detail->qty + $model->qty;
                    $penjualan_detail->total_jual = $penjualan_detail->harga_jual * $penjualan_detail->qty;
                    $penjualan_detail->save(false);
                } else {
                    $model->save(false);
                }

                $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();
                $grandtotal = 0;
                foreach ($penjualan_detail as $key => $value) {
                    $grandtotal += $value->total_jual;
                }

                $penjualan = DataPenjualanBarang::find()->where(['id_penjualan' => $id])->one();
                $penjualan->grandtotal = $grandtotal;
                $penjualan->save(false);
                // Yii::$app->session->setFlash("success", "Disimpan");
            }
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }
    }

    public function actionTambahPenjualanDetailBarcode()
    {
        $model = new DataPenjualanDetail();
        if ($model->load(Yii::$app->request->post())) {
            $id = $model->id_penjualan;
            $model->qty = 1;
            $barang = DataBarang::find()->where(['kode_barang' => $model->id_barang])->one();
            if (!empty($barang->id_barang)) {

                $cek_stok_keluar = StokKeluar::find()->where('YEAR(tanggal_keluar) = ' . date('Y'))->andWhere('MONTH(tanggal_keluar) = ' . date('m'))->andWhere(['id_barang' => $barang->id_barang])->count();

                if ($model->qty > $barang->stok) {
                    Yii::$app->session->setFlash("error", "Stok Barang tidak mencukupi");
                } else {
                    if ($cek_stok_keluar == 0) {
                        # insert
                        $stok_keluar_tambah = new StokKeluar();
                        $stok_keluar_tambah->id_barang = $barang->id_barang;
                        $stok_keluar_tambah->tanggal_keluar = date('Y-m-d');
                        $stok_keluar_tambah->total_qty = $model->qty;
                        $stok_keluar_tambah->save(false);
                        $model->id_stok_keluar = $stok_keluar_tambah->id_stok_keluar;
                    } else {
                        # update
                        $stok_keluar_ubah = StokKeluar::find()
                            ->where('YEAR(tanggal_keluar) = ' . date('Y'))->andWhere('MONTH(tanggal_keluar) = ' . date('m'))
                            ->andWhere(['id_barang' => $barang->id_barang])
                            ->one();
                        $stok_keluar_ubah->total_qty = $stok_keluar_ubah->total_qty + $model->qty;
                        // var_dump($stok_keluar_ubah->total_qty);
                        // die;
                        $stok_keluar_ubah->save(false);
                        $model->id_stok_keluar = $stok_keluar_ubah->id_stok_keluar;
                    }

                    $model->id_barang = $barang->id_barang;
                    $model->harga_jual = $barang->harga_jual;
                    $model->total_jual = $model->harga_jual * $model->qty;
                    $penjualan_detail = DataPenjualanDetail::find()->where(['id_barang' => $model->id_barang])->andWhere(['id_penjualan' => $model->id_penjualan])->one();
                    if (!empty($penjualan_detail->id_penjualan_detail)) {
                        $penjualan_detail->qty = $penjualan_detail->qty + $model->qty;
                        $penjualan_detail->total_jual = $penjualan_detail->harga_jual * $penjualan_detail->qty;
                        $penjualan_detail->save(false);
                    } else {
                        $model->save(false);
                    }

                    $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();
                    $grandtotal = 0;
                    foreach ($penjualan_detail as $key => $value) {
                        $grandtotal += $value->total_jual;
                    }

                    $penjualan = DataPenjualanBarang::find()->where(['id_penjualan' => $id])->one();
                    $penjualan->grandtotal = $grandtotal;
                    $penjualan->save(false);
                    // Yii::$app->session->setFlash("success", "Disimpan");
                }
            } else {
                Yii::$app->session->setFlash("error", "Barang tidak ada!");
            }
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }
    }

    public function actionGetPenjualanDetail($id)
    {
        $model = DataPenjualanDetail::find()->where(['id_penjualan_detail' => $id])->asArray()->one();
        return json_encode($model);
    }

    public function actionEditQty($id)
    {
        $model = DataPenjualanDetail::find()->where(['id_penjualan_detail' => $id])->one();
        $cek_harga = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();

        if ($_POST['qty'] > $cek_harga->stok) {
            Yii::$app->session->setFlash("error", "Stok Barang tidak mencukupi");
        } else {
            $model->qty = $_POST['qty'];
            $model->total_jual = $model->harga_jual * $model->qty;
            $model->save(false);
        }
        // Yii::$app->session->setFlash("success", "Disimpan");
        return $this->redirect(['data-penjualan-barang/view', 'id' => $model->id_penjualan]);
    }

    public function actionDeletePenjualanDetail($id)
    {
        $model = DataPenjualanDetail::find()->where(['id_penjualan_detail' => $id])->one();
        $stok_keluar = StokKeluar::find()->where(['id_stok_keluar' => $model->id_stok_keluar])->one();
        $stok_keluar->total_qty = $stok_keluar->total_qty - $model->qty;
        $stok_keluar->save(false);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Dihapus');
        return $this->redirect(['data-penjualan-barang/view', 'id' => $model->id_penjualan]);
    }

    /**
     * Creates a new DataPenjualanBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new DataPenjualanBarang();
    //     $model2 = new AnggotaKoperasi();

    //     $model->tanggal_penjualan = date('Y-m-d');


    //     $data_anggota = ArrayHelper::map(
    //         AnggotaKoperasi::find()->where('id_jenis_anggota != 2')->all(),
    //         'id_anggota',
    //         function ($model) {
    //             return $model['kode_anggota'] . ' - ' . $model['nama_anggota'];
    //         }
    //     );

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         Yii::$app->session->setFlash('success', 'Disimpan');
    //         return $this->redirect(['view', 'id' => $model->id_penjualan]);
    //     }

    //     return $this->renderAjax('create', [
    //         'model' => $model,
    //         'model2' => $model2,
    //         'data_anggota' => $data_anggota,
    //     ]);
    // }

    public function actionCreateStok($id)
    {
        $model = new StokKeluar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }
    }

    // public function actionCreateAnggota()
    // {
    //     $model = new AnggotaKoperasi();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         Yii::$app->session->setFlash('success', 'Disimpan');
    //         return $this->redirect(['index']);
    //     }
    // }

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
        $model2 = new AnggotaKoperasi();

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
            'model2' => $model2,
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
        $model = $this->findModel($id);
        DataPenjualanDetail::deleteAll(
            [
                'id_penjualan' => $id
            ],
        );
        $model->delete();

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
        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();

        if ($update->no_invoice == '') {

            $generate = DataPenjualanBarang::find()->count();
            $total = 0;
            foreach ($penjualan_detail as $key => $val) {
                $total += $val->total_jual;
            }
            // var_dump($total, Yii::$app->request->post('bayar'));
            // die;
            if (Yii::$app->request->post('bayar') >= $total) {
                // echo 'ok';
                foreach ($penjualan_detail as $key => $val) {
                    $barang = DataBarang::find()->where(['id_barang' => $val->id_barang])->one();
                    $barang->stok = $barang->stok - $val->qty;
                    $barang->save(false);
                }
                $update->no_invoice = date('Ymd') . str_pad($generate + 1, 3, "0", STR_PAD_LEFT);
                $update->jenis_pembayaran = 1;
                $update->jumlah_bayar = Yii::$app->request->post('bayar');

                $update->save(false);
                return $this->redirect(['data-penjualan-barang/cetak', 'id' => $id]);
            } else if (Yii::$app->request->post('bayar') < $total) {
                Yii::$app->session->setFlash('error', 'Jumlah Uang yang anda masukan kurang dari total tagihan!');
                return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
            }
            die;
        }



        return $this->renderPartial('cetak', [
            'model' => $model,
            'penjualan_detail' => $penjualan_detail,
            // 'data_anggota' => $data_anggota,
        ]);
    }

    public function actionCetakTagihan($id)
    {
        $model = $this->findModel($id);
        $update = DataPenjualanBarang::findOne($id);
        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();

        if ($update->no_invoice == '') {

            $generate = DataPenjualanBarang::find()->count();
            $update->no_invoice = date('Ymd') . str_pad($generate + 1, 3, "0", STR_PAD_LEFT);
            $update->jenis_pembayaran = 2;

            foreach ($penjualan_detail as $key => $val) {
                $barang = DataBarang::find()->where(['id_barang' => $val->id_barang])->one();
                $barang->stok = $barang->stok - $val->qty;
                $barang->save(false);
            }
            // $update->jumlah_bayar = Yii::$app->request->post('bayar');
            $update->save(false);

            return $this->redirect(['data-penjualan-barang/cetak', 'id' => $id]);
        }



        return $this->renderPartial('cetak', [
            'model' => $model,
            'penjualan_detail' => $penjualan_detail,
            // 'data_anggota' => $data_anggota,
        ]);
    }
}

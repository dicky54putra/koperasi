<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPenjualanDetail;
use backend\models\DataPenjualanDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use yii\helpers\ArrayHelper;

use backend\models\DataPenjualanBarang;
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
                    'delete' => ['POST', 'GET'],
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
        $model2 = new StokKeluar();

        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['kode_barang'] . ' - ' . $model['nama_barang'];
            }
        );

        $data_stok_keluar = ArrayHelper::map(
            StokKeluar::find()->all(),
            'id_stok_keluar',
            function ($model) {
                return tanggal_indo($model['tanggal_keluar'], true) . ' - ' . $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();
            $grandtotal = 0;
            foreach ($penjualan_detail as $key => $value) {
                $grandtotal += $value->total_jual;
            }

            $data_stok_barang = StokKeluar::find()
                ->where(['id_stok_keluar' => Yii::$app->request->post('DataPenjualanDetail')['id_stok_keluar']])
                ->andWhere(['id_barang' => Yii::$app->request->post('DataPenjualanDetail')['id_barang']])
                ->one();
            $data_stok_barang->total_qty = $data_stok_barang->total_qty + Yii::$app->request->post('DataPenjualanDetail')['qty'];
            // var_dump($data_stok_barang->total_qty);
            // die;
            $data_stok_barang->save(false);

            $penjualan = DataPenjualanBarang::find()->where(['id_penjualan' => $id])->one();
            $penjualan->grandtotal = $grandtotal;
            $penjualan->save(false);



            Yii::$app->session->setFlash("success", "Disimpan");
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'model2' => $model2,
            'data_barang' => $data_barang,
            'data_stok_keluar' => $data_stok_keluar,
        ]);
    }

    public function actionStok()
    {
        $country_id = $_POST['depdrop_parents'][0];
        $state = Yii::$app->db->createCommand("SELECT * FROM stok_keluar WHERE id_barang = '$country_id'")->query();
        $all_state = array();
        $i = 0;
        foreach ($state as $value) {
            $all_state[$i]['id'] = empty($value['id_stok_keluar']) ? 0 : $value['id_stok_keluar'];
            $all_state[$i]['name'] = empty($value['tanggal_keluar']) ? 'Data Kosong' : tanggal_indo2(date('F', strtotime($value['tanggal_keluar'])));
            $i++;
        }

        echo Json::encode(['output' => $all_state, 'selected' => '']);
        return;
    }

    public function actionGetDataBarang($id)
    {
        $data_barang = DataBarang::find()->where(['id_barang' => $id])->one();
        echo Json::encode($data_barang);
    }

    /**
     * Updates an existing DataPenjualanDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $id_detail)
    {
        $model = $this->findModel($id_detail);
        $model2 = new StokKeluar();

        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['kode_barang'] . ' - ' . $model['nama_barang'];
            }
        );

        $data_stok_keluar = ArrayHelper::map(
            StokKeluar::find()->all(),
            'id_stok_keluar',
            function ($model) {
                return tanggal_indo($model['tanggal_keluar'], true) . ' - ' . $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", "Disimpan");
            return $this->redirect(['data-penjualan-barang/view', 'id' => $id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'model2' => $model2,
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
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Dihapus');
        return $this->redirect(['data-pembelian-barang/view', 'id' => $model->id_penjualan]);
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

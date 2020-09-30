<?php

namespace backend\controllers;

use Yii;
use backend\models\DataPembelianDetail;
use backend\models\DataPembelianDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use backend\models\DataPembelianBarang;
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
                    'delete' => ['POST', 'GET'],
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
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
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
        $model2 = new StokMasuk();

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
                return tanggal_indo2(date('F', strtotime($model['tanggal_masuk']))) . ' - ' . $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

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

        return $this->renderAjax('create', [
            'model' => $model,
            'model2' => $model2,
            'data_barang' => $data_barang,
            'data_stok_masuk' => $data_stok_masuk,
        ]);
    }

    public function actionGetDataBarang($id)
    {
        $data_barang = DataBarang::find()->where(['id_barang' => $id])->one();
        echo Json::encode($data_barang);
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
                return tanggal_indo($model['tanggal_masuk'], true) . ' - ' . $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['data-pembelian-barang/view', 'id' => $id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'data_barang' => $data_barang,
            'data_stok_masuk' => $data_stok_masuk,
        ]);
    }

    public function actionStok()
    {
        $country_id = $_POST['depdrop_parents'][0];
        $state = Yii::$app->db->createCommand("
        SELECT * FROM stok_masuk WHERE id_barang = '$country_id'")->query();
        $all_state = array();
        $i = 0;
        foreach ($state as $value) {
            $all_state[$i]['id'] = empty($value['id_stok_masuk']) ? 0 : $value['id_stok_masuk'];
            $all_state[$i]['name'] = empty($value['tanggal_masuk']) ? 'Data Kosong' : tanggal_indo2(date('F', strtotime($value['tanggal_masuk'])));
            $i++;
        }

        echo Json::encode(['output' => $all_state, 'selected' => '']);
        return;
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

        Yii::$app->session->setFlash('success', 'Dihapus');
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

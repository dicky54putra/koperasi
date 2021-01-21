<?php

namespace backend\controllers;

use Yii;
use backend\models\StokPenyesuaian;
use backend\models\StokPenyesuaianDetail;
use backend\models\StokPenyesuaianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\DataBarang;
use backend\models\StokTitipan;

/**
 * StokPenyesuaianController implements the CRUD actions for StokPenyesuaian model.
 */
class StokTitipanController extends Controller
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
     * Lists all StokPenyesuaian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new StokTitipan();
        $data_titipan = StokTitipan::find()->where(['tanggal' => date('Y-m-d')])->orderBy('id_stok_titipan DESC')->all();
        $data_barang = DataBarang::find()->where(['tipe' => 1])->all();

        return $this->render('index', [
            'model' => $model,
            'data_titipan' => $data_titipan,
            'data_barang' => $data_barang,
        ]);
    }

    /**
     * Displays a single StokPenyesuaian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionCreate()
    {
        $model = new StokTitipan();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->qty > 0) {
                $barang = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();
                $barang->stok = $barang->stok + $model->qty;
                $barang->save(false);
                $model->save();
            } else {
                Yii::$app->session->setFlash('error', 'Quantitas tidak boleh mines!');
            }
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }
    }

    public function actionGetBarang($id)
    {
        $model = DataBarang::find()->where(['id_barang' => $id])->asArray()->one();
        return json_encode($model);
    }

    /**
     * Updates an existing StokPenyesuaian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionCetakStokBarang()
    {
        return $this->renderPartial('stok-barang');
    }

    public function actionEksporStokBarang()
    {
        return $this->renderPartial('ekspor-stok-barang');
    }

    public function actionDiambil($id)
    {
        $model = new StokTitipan();
        $barang = DataBarang::find()->where(['id_barang' => $id])->one();
        $model->id_barang = $id;
        $model->qty = $barang->stok;
        $model->keterangan = 'diambil';
        $model->tanggal = date('Y-m-d');
        $barang->stok = 0;
        $model->save(false);
        $barang->save(false);
        Yii::$app->session->setFlash('success', 'Disimpan');
        return $this->redirect(['index']);
    }

    /**
     * Finds the StokPenyesuaian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StokPenyesuaian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StokPenyesuaian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

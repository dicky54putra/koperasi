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

/**
 * StokPenyesuaianController implements the CRUD actions for StokPenyesuaian model.
 */
class StokPenyesuaianController extends Controller
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
        $model = new StokPenyesuaian();
        $data_penyesuaian = StokPenyesuaian::find()->where(['tanggal' => date('Y-m-d')])->orderBy('id_stok_penyesuaian DESC')->all();
        $data_barang = DataBarang::find()->all();

        return $this->render('index', [
            'model' => $model,
            'data_penyesuaian' => $data_penyesuaian,
            'data_barang' => $data_barang,
        ]);
    }

    /**
     * Displays a single StokPenyesuaian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_detail = new StokPenyesuaianDetail();
        $data_penyesuaian_detail = StokPenyesuaianDetail::find()->where(['id_stok_penyesuaian' => $id])->all();
        $data_barang = ArrayHelper::map(
            DataBarang::find()->all(),
            'id_barang',
            function ($model) {
                return $model['kode_barang'] . ' - ' . $model['nama_barang'];
            }
        );

        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_detail' => $model_detail,
            'data_barang' => $data_barang,
            'data_penyesuaian_detail' => $data_penyesuaian_detail,
        ]);
    }

    /**
     * Creates a new StokPenyesuaian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StokPenyesuaian();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->qty > 0) {
                $barang = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();
                if ($model->tipe == 1) {
                    $barang->stok = $barang->stok + $model->qty;
                } elseif ($model->tipe == 2) {
                    if ($barang->stok >= $model->qty) {
                        $barang->stok = $barang->stok - $model->qty;
                    } else {
                        Yii::$app->session->setFlash('error', 'Quantitas melebihi stok! Stok tidak bisa mines');
                    }
                }

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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_stok_penyesuaian]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StokPenyesuaian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $barang = DataBarang::find()->where(['id_barang' => $model->id_barang])->one();
        $barang->stok = $barang->stok - $model->qty;
        $barang->save(false);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Dihapus');
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

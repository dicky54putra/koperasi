<?php

namespace backend\controllers;

use Yii;
use backend\models\SimpanPinjam;
use backend\models\SimpanPinjamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AnggotaKoperasi;
use yii\helpers\ArrayHelper;

use yii\helpers\Json;
use backend\models\Pelunasan;


/**
 * SimpanPinjamController implements the CRUD actions for SimpanPinjam model.
 */
class SimpanPinjamController extends Controller
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
     * Lists all SimpanPinjam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SimpanPinjamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data_simpan = SimpanPinjam::find()->where(['jenis' =>1])->all();

        $data_pinjam = SimpanPinjam::find()->where(['jenis' =>2])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data_pinjam' => $data_pinjam,
            'data_simpan' => $data_simpan,
        ]);
    }

    /**
     * Displays a single SimpanPinjam model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $data_pelunasan = Pelunasan::find()->where(['id_simpan_pinjam' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data_pelunasan' => $data_pelunasan,
        ]);
    }

    /**
     * Creates a new SimpanPinjam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateSimpan()
    {
        $model = new SimpanPinjam();


        $data_anggota = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->all(),
            'id_anggota',
            function ($model) {
                return $model['kode_anggota'] .' - '.$model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create-simpan', [
            'model' => $model,
            'data_anggota' => $data_anggota,
        ]);
    }

    public function actionCreatePinjam()
    {
        $model = new SimpanPinjam();


        $data_anggota = ArrayHelper::map(
            AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->all(),
            'id_anggota',
            function ($model) {
                return $model['kode_anggota'] .' - '.$model['nama_anggota'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create-pinjam', [
            'model' => $model,
            'data_anggota' => $data_anggota,
        ]);
    }

    /**
     * Updates an existing SimpanPinjam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatePinjam($id)
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
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update-pinjam', [
            'model' => $model,
            'data_anggota' => $data_anggota,
        ]);
    }

    public function actionUpdateSimpan($id)
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
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update-simpan', [
            'model' => $model,
            'data_anggota' => $data_anggota,
        ]);
    }

    /**
     * Deletes an existing SimpanPinjam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SimpanPinjam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SimpanPinjam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SimpanPinjam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

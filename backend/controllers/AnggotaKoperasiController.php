<?php

namespace backend\controllers;

use Yii;
use backend\models\AnggotaKoperasi;
use backend\models\AnggotaKoperasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
use backend\models\DataPenjualanBarang;


/**
 * AnggotaKoperasiController implements the CRUD actions for AnggotaKoperasi model.
 */
class AnggotaKoperasiController extends Controller
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
     * Lists all AnggotaKoperasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnggotaKoperasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $anggota = AnggotaKoperasi::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'anggota' => $anggota,
        ]);
    }

    /**
     * Displays a single AnggotaKoperasi model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $pembelian_history = DataPenjualanBarang::find()->where(['id_anggota' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'pembelian_history' => $pembelian_history,
        ]);
    }

    /**
     * Creates a new AnggotaKoperasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnggotaKoperasi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AnggotaKoperasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Disimpan');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AnggotaKoperasi model.
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

    public function actionPrintKartu($id)
    {
        $model = $this->findModel($id);
        $searchModel = new AnggotaKoperasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('print_kartu', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);

        // $pdf = Yii::$app->pdf;
        // $pdf->content = $this->renderPartial('print_kartu');
        // return $pdf->render();  

        // $print =  $this->renderPartial('print_kartu', [
        // return $this->render('print', [
        // 'model'       => $this->findModel($id),
        // 'po'          => $this->getArrayPo(),
        // 'detailpo'    => $this->getArrayDetailpo($id),
        // ]);

        // $mPDF = new mPDF();
        // $mPDF->showImageErrors = true;
        // $mPDF->writeHTML($print);
        // $mPDF->Output();
        // exit();
    }

    /**
     * Finds the AnggotaKoperasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnggotaKoperasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnggotaKoperasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

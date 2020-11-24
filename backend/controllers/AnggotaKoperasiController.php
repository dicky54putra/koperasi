<?php

namespace backend\controllers;

use Yii;
use backend\models\AnggotaKoperasi;
use backend\models\AnggotaKoperasiSearch;
use backend\models\DataBarang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
use backend\models\DataPenjualanBarang;
use backend\models\DataPenjualanDetail;
use yii\data\Pagination;

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
        $anggota = AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->all();

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
        $query = DataPenjualanBarang::find()->where(['id_anggota' => $id])->orderBy('id_penjualan DESC');
        // $countQuery = clone $query;
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);
        $pembelian_history = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        // $pembelian_history = DataPenjualanBarang::find()->where(['id_anggota' => $id])->orderBy('id_penjualan DESC')->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'pembelian_history' => $pembelian_history,
            'pages' => $pages,
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
        $generate = AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->count();
        $model->kode_anggota  = 20201127 . str_pad($generate + 1, 4, "0", STR_PAD_LEFT);
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

    public function actionPrintKartuAll()
    {
        $searchModel = new AnggotaKoperasiSearch();
        $data = AnggotaKoperasi::find()->where(['id_jenis_anggota' => 1])->all();

        return $this->render('print_kartu_all', [
            // 'dataProvider' => $dataProvider,
            'data' => $data
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

    public function actionPrintTagihan($id)
    {
        $update = DataPenjualanBarang::findOne($id);
        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();

        $generate = DataPenjualanBarang::find()->count();
        $total = 0;
        foreach ($penjualan_detail as $key => $val) {
            $total += $val->total_jual;
        }
        // var_dump($total, Yii::$app->request->post('bayar'));
        // die;
        if (Yii::$app->request->post('bayar') >= $total) {
            // echo 'ok';
            // foreach ($penjualan_detail as $key => $val) {
            //     $barang = DataBarang::find()->where(['id_barang' => $val->id_barang])->one();
            //     $barang->stok = $barang->stok - $val->qty;
            //     $barang->save(false);
            // }
            $update->no_invoice = date('Ymd') . str_pad($generate + 1, 3, "0", STR_PAD_LEFT);
            $update->jenis_pembayaran = 1;
            $update->jumlah_bayar = Yii::$app->request->post('bayar');

            $update->save(false);
            return $this->redirect(['anggota-koperasi/print-struk', 'id' => $id]);
        } else if (Yii::$app->request->post('bayar') < $total) {
            Yii::$app->session->setFlash('error', 'Jumlah Uang yang anda masukan kurang dari total tagihan!');
            return $this->redirect(['anggota-koperasi/view', 'id' => $update->id_anggota]);
        }
    }

    public function actionPrintTagihanSemua($id)
    {
        $model = $this->findModel($id);
        $penjualan = DataPenjualanBarang::find()->where(['id_anggota' => $id])->andWhere(['jenis_pembayaran' => 2])->all();

        $total = 0;
        $generate = DataPenjualanBarang::find()->count();
        foreach ($penjualan as $key => $value) {
            $total_nominal = Yii::$app->db->createCommand("SELECT SUM(total_jual) FROM data_penjualan_detail LEFT JOIN data_penjualan_barang ON data_penjualan_barang.id_penjualan = data_penjualan_detail.id_penjualan WHERE data_penjualan_barang.id_anggota = '$model->id_anggota' AND data_penjualan_barang.jenis_pembayaran = '2'")->queryScalar();
            $u_penjualan = DataPenjualanBarang::find()->where(['id_penjualan' => $value->id_penjualan])->one();
            $u_penjualan->no_invoice = date('Ymd') . str_pad($generate + 1, 3, "0", STR_PAD_LEFT);
            $u_penjualan->jenis_pembayaran = 1;

            $u_penjualan->save(false);
            // if (Yii::$app->request->post('bayar') >= $total_nominal) {
            // echo $total_nominal;
            // } else {
            //     // var_dump($total_nominal);
            //     return $this->redirect(['anggota-koperasi/view', 'id' => $id]);
            // }
            // die;
            // echo $value->id_penjualan . '-' . $u_penjualan->jenis_pembayaran . '<br>';
        }
        return $this->redirect(['anggota-koperasi/view', 'id' => $id]);
        // return $this->redirect(['anggota-koperasi/print-struk-semua', 'id' => $id]);
    }

    public function actionPrintStruk($id)
    {
        // $update = DataPenjualanBarang::findOne($id);
        $model = DataPenjualanBarang::findOne($id);
        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();
        return $this->renderPartial('print_tagihan', [
            'model' => $model,
            'penjualan_detail' => $penjualan_detail,
            // 'data_anggota' => $data_anggota,
        ]);
    }

    public function actionPrintStrukSemua($id)
    {
        $model = AnggotaKoperasi::findOne($id);
        // $model = DataPenjualanBarang::find()->where(['id_anggota' => $id])->one();
        $penjualan_detail = DataPenjualanDetail::find()->where(['id_penjualan' => $id])->all();
        return $this->renderPartial('print-struk-semua', [
            'model' => $model,
            'penjualan_detail' => $penjualan_detail,
            // 'data_anggota' => $data_anggota,
        ]);
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

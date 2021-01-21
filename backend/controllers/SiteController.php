<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\Log;

use backend\models\AktAkun;
use backend\models\AktKasBank;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'popup', 'blocked'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'popup', 'blocked'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionPopup()
    {
        return $this->render('popup');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    public function actionBlocked()
    {
        return $this->renderPartial('blocked');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $month = date('m');
        $year = date('Y');

        $tanggal = Yii::$app->db->createCommand("SELECT tanggal_penjualan FROM data_penjualan_barang WHERE  MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year' GROUP BY tanggal_penjualan ORDER BY tanggal_penjualan ASC")->query();
        $tanggal2 = Yii::$app->db->createCommand("SELECT tanggal_pembelian FROM data_pembelian_barang WHERE  MONTH(tanggal_pembelian) = '$month' AND YEAR(tanggal_pembelian) = '$year' GROUP BY tanggal_pembelian ORDER BY tanggal_pembelian ASC")->query();

        $omzet = Yii::$app->db->createCommand("SELECT sum(grandtotal) FROM data_penjualan_barang WHERE  MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year'")->queryScalar();
        $pengeluaran = Yii::$app->db->createCommand("SELECT sum(total_beli) FROM data_pembelian_detail LEFT JOIN data_pembelian_barang ON data_pembelian_barang.id_pembelian = data_pembelian_detail.id_pembelian WHERE  MONTH(tanggal_pembelian) = '$month' AND YEAR(tanggal_pembelian) = '$year'")->queryScalar();
        $barang = Yii::$app->db->createCommand("SELECT count(id_barang) FROM data_barang")->queryScalar();
        // $tanggal_penjualan = Yii::$app->db->createCommand("SELECT tanggal_penjualan FROM data_penjualan_barang WHERE  MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year' GROUP BY tanggal_penjualan")->query();
        // $tanggal_pembelian = Yii::$app->db->createCommand("SELECT tanggal_pembelian FROM data_pembelian_barang 
        // WHERE  MONTH(tanggal_pembelian) = '$month' AND YEAR(tanggal_pembelian) = '$year' GROUP BY 
        // tanggal_pembelian")->query();

        $tanggal_labels = Yii::$app->db->createCommand("SELECT tanggal_penjualan FROM data_penjualan_barang WHERE  MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year' GROUP BY tanggal_penjualan ORDER BY tanggal_penjualan ASC")->query();
        $tanggal_labels2 = Yii::$app->db->createCommand("SELECT tanggal_pembelian FROM data_pembelian_barang WHERE  MONTH(tanggal_pembelian) = '$month' AND YEAR(tanggal_pembelian) = '$year' GROUP BY tanggal_pembelian ORDER BY tanggal_pembelian ASC")->query();


        return $this->render('index', [
            'tanggal_label' => $tanggal_labels,
            'tanggal_label2' => $tanggal_labels2,
            'tanggal' => $tanggal,
            'tanggal2' => $tanggal2,
            'omzet' => $omzet ?? 0,
            'pengeluaran' => $pengeluaran ?? 0,
            'barang' => $barang,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $input_log = new Log();
            $input_log->level = '0';
            $input_log->category = 'Login';
            $input_log->log_time = microtime('get_as_float');
            $input_log->prefix = Yii::$app->user->identity->nama;
            $input_log->message = 'Login';
            $input_log->save(false);

            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

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
                        'actions' => ['login', 'error', 'popup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'popup'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $month = date('m');
        $year = date('Y');

        $tanggal = Yii::$app->db->createCommand("SELECT tanggal_penjualan FROM data_penjualan_barang WHERE MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year' GROUP BY tanggal_penjualan")->query();
        // echo $month . '-' . $year;
        // foreach ($tanggal as $key => $value) {
        //     # code...
        //     // echo $value->tanggal_penjualan;
        //     echo $value['tanggal_penjualan'];
        //     // echo $value;
        // }
        // die;
        $tanggal_labels = Yii::$app->db->createCommand("SELECT tanggal_penjualan FROM data_penjualan_barang WHERE MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year' GROUP BY tanggal_penjualan")->query();

        // $pembelian = Yii::$app->db->createCommand("SELECT SUM(akt_penjualan_detail.qty) AS penjualan, akt_item.nama_item FROM `akt_penjualan_detail` LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penjualan_detail.id_penjualan LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item WHERE MONTH(tanggal_order_penjualan) = '$month' AND YEAR(tanggal_order_penjualan) = '$year'  GROUP BY akt_item.id_item ORDER BY penjualan DESC LIMIT 5")->query();
        return $this->render('index', [
            'tanggal_labels' => $tanggal_labels,
            'tanggal' => $tanggal
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

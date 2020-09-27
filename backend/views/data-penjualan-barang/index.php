<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataPenjualanBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penjualan Barangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-penjualan-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Penjualan Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penjualan',
            'tanggal_penjualan',
            'id_anggota',
            'jenis_pembayaran',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataPenjualanDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penjualan Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-penjualan-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Penjualan Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penjualan_detail',
            'id_penjualan',
            'id_stok_keluar',
            'id_barang',
            'qty',
            //'diskon',
            //'harga_jual',
            //'ppn',
            //'total_jual',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

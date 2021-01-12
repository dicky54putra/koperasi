<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataPembelianDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pembelian Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pembelian-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Pembelian Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pembelian_detail',
            'id_pembelian',
            'id_stok_masuk',
            'id_barang',
            'qty',
            //'diskon',
            //'harga_beli',
            //'ppn',
            //'total_beli',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

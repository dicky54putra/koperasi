<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StokPenyesuaianDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stok Penyesuaian Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-penyesuaian-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stok Penyesuaian Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_stok_penyesuaian_detail',
            'id_stok_penyesuaian',
            'id_barang',
            'qty',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

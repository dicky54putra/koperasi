<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataSatuanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Satuans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-satuan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Satuan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_satuan',
            'nama_satuan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

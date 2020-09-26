<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataPangkatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pangkats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pangkat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Pangkat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pangkat',
            'nama_pangkat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JenisAnggotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jenis Anggotas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-anggota-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Jenis Anggota', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_jenis',
            'nama_jenis',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

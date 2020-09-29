<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */

$this->title = $model->id_simpan_pinjam;
$this->params['breadcrumbs'][] = ['label' => 'Simpan Pinjams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="simpan-pinjam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_simpan_pinjam], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_simpan_pinjam], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_simpan_pinjam',
            'id_anggota',
            'jenis',
            'tanggal',
            'status',
            'keterangan:ntext',
        ],
    ]) ?>

</div>

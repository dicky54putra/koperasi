<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */

$this->title = $model->id_barang;
$this->params['breadcrumbs'][] = ['label' => 'Data Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="data-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_barang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_barang], [
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
            'id_barang',
            'id_kategori',
            'id_satuan',
            'kode_barang',
            'nama_barang',
            'id_anggota',
            'harga_jual',
            'harga_beli',
            'is_active',
        ],
    ]) ?>

</div>

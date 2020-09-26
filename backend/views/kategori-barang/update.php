<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\KategoriBarang */

$this->title = 'Update Kategori Barang: ' . $model->id_kategori;
$this->params['breadcrumbs'][] = ['label' => 'Kategori Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_kategori, 'url' => ['view', 'id' => $model->id_kategori]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kategori-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

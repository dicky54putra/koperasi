<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\KategoriBarang */

$this->title = 'Create Kategori Barang';
$this->params['breadcrumbs'][] = ['label' => 'Kategori Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

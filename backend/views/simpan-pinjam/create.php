<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */

$this->title = 'Create Simpan Pinjam';
$this->params['breadcrumbs'][] = ['label' => 'Simpan Pinjams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simpan-pinjam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

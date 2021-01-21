<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StokPenyesuaian */

$this->title = 'Create Stok Penyesuaian';
$this->params['breadcrumbs'][] = ['label' => 'Stok Penyesuaians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-penyesuaian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

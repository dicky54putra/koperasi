<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataPangkat */

$this->title = 'Tambah Data Pangkat';
$this->params['breadcrumbs'][] = ['label' => 'Data Pangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-pangkat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
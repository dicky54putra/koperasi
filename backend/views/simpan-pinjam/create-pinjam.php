<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */

$this->title = 'Tambah Data Pinjam';
$this->params['breadcrumbs'][] = ['label' => 'Simpan Pinjams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pinjam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-pinjam', [
        'model' => $model,
            'data_anggota' => $data_anggota,
    ]) ?>

</div>

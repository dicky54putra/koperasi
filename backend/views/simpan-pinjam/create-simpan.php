<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SimpanPinjam */

$this->title = 'Tambah Data Simpan';
$this->params['breadcrumbs'][] = ['label' => 'Simpan Pinjams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simpan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-simpan', [
        'model' => $model,
            'data_anggota' => $data_anggota,
    ]) ?>

</div>

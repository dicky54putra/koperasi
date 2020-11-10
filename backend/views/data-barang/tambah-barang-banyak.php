<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\DataBarang */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Tambah Barang Banyak ';
?>

<div class="data-barang-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li><?= Html::a('Data Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="row">
        <?= Html::beginForm($action = 'index.php?r=data-barang/tambah-barang-banyak', $method = 'get') ?>
        <div class="col-lg-2">
            <?php
            $banyak = ['nama' => 1, 2, 3, 4, 5, 6];
            ?>
            <select name="count" id="count" class="form-control">
                <?php
                foreach ($banyak as $key => $value) {
                ?>
                    <option value="<?= $value ?>" <?= ($value == $count) ? 'selected' : ''; ?>><?= $value ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-2">
            <button id="button-count" class="btn btn-primary">Count</button>
        </div>
        <?= Html::endForm() ?>
        <?php $form = ActiveForm::begin(); ?>
        <?php
        for ($i = 0; $i < $count; $i++) {
        ?>
            <?= $form->field($model, 'harga_jual')->textInput() ?>
        <?php } ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success pull-right']) ?>
        <?php ActiveForm::end(); ?>
    </div>

</div>
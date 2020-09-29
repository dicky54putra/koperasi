<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\SimpanPinjamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Simpan Pinjam';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simpan-pinjam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-12" style="margin-top:20px;">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#simpanan"><span class="fa fa-bank"></span> Simpanan</a></li>
                        <li><a data-toggle="tab" href="#pinjaman"><span class="fa fa-credit-card"></span> Pinjaman</a></li>
                    </ul>
                <div class="tab-content">

                    <div id="simpanan" class="tab-pane fade in active" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <p>
                                    <?= Html::button(
                                        '<span class="glyphicon glyphicon-plus"></span> Tambah',
                                        [
                                            'value' => Url::to(['create']),
                                            'title' => 'Tambah data',
                                            'class' => 'showModalButton btn btn-primary'
                                        ]
                                    ); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="pinjaman" class="tab-pane fade" style="margin-top:20px;">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12" style="overflow: auto;">
                                <p>
                                    <?= Html::button(
                                        '<span class="glyphicon glyphicon-plus"></span> Tambah',
                                        [
                                            'value' => Url::to(['create']),
                                            'title' => 'Tambah data',
                                            'class' => 'showModalButton btn btn-primary'
                                        ]
                                    ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php

use backend\models\DataSatuan;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Barang';
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="data-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Dashboard</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::button(
            '<i class="glyphicon glyphicon-plus"></i> Tambah Data Barang',
            [
                'value' => Url::to(['create']),
                'title' => '', 'class' => 'showModalButton btn btn-success'
            ]
        );  ?>
        <!-- <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Barang Banyak', ['tambah-barang-banyak'], ['class' => 'btn btn-warning']) ?> -->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update} {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::button(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            [
                                'value' => Url::to(['update', 'id' => $model->id_barang]),
                                'title' => 'Ubah data', 'class' => 'showModalButton btn btn-success'
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                                'method' => 'post'
                            ],
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=data-barang/view&id=' . $model->id_barang;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=data-barang/update&id=' . $model->id_barang;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=data-barang/delete&id=' . $model->id_barang;
                        return $url;
                    }
                }
            ],
            'nama_barang',
            [
                'attribute' => 'kategori',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->kategori_barang->nama_kategori;
                }
            ],
            [
                'attribute' => 'tipe',
                'format' => 'raw',
                'filter' => array(0 => 'Barang Pembelian', 1 => 'Barang Titipan'),
                'value' => function ($model) {
                    return ($model->tipe == 0) ? 'Barang Pembelian' : 'Barang Titipan';
                }
            ],
            [
                'attribute' => 'satuan',
                'format' => 'raw',
                'value' => function ($model) {
                    $q = DataSatuan::findOne($model->id_satuan);
                    return $q->nama_satuan ?? '';
                }
            ],
            'harga_jual',
            'harga_beli',
            'stok',
            [
                'attribute' => 'is_active',
                'label' => 'Status',
                'filter' => array(1 => 'Aktif', 2 => 'Tidak Aktif'),
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->is_active == 2) {
                        return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                    } else if ($model->is_active == 1) {
                        return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                    }
                }
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [

            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        // parameters from the demo form
        //'bordered' => $bordered,
        //'striped' => $striped,
        //'condensed' => $condensed,
        //'responsive' => $responsive,
        //'hover' => $hover,
        //'showPageSummary' => $pageSummary,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-map-marker-alt"></span> Daftar Kota',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false,
            'target' => GridView::TARGET_BLANK
        ],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data Kota',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>
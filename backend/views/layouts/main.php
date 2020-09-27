<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->user->isGuest) {

    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->name) ?></title>
        <!-- DataTables -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"> -->
        <link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <style>
            ::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            ::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                border-radius: 10px;
                background: rgba(0, 0, 0, 0.2);
                /* -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3); */
            }
        </style>
        <?php $this->head() ?>
    </head>

    <body class="hold-transition skin-yellow sidebar-mini fixed">
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <?= $this->render(
                'header.php',
                ['directoryAsset' => $directoryAsset]
            ) ?>

            <?= $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>

            <?= $this->render(
                'content.php',
                ['content' => $content, 'directoryAsset' => $directoryAsset]
            ) ?>

            <?php
            yii\bootstrap\Modal::begin([
                // 'headerOptions' => ['id' => 'modalHeader'],
                'options' => ['tabindex' => false],
                'id' => 'modal',
                'size' => 'modal-lg',
                // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => true]
            ]);
            echo '<div class="box box-warning">
            <div class="box-header">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">';
            echo "<div id='modalContent'></div>";
            echo '</div></div></div></div>';
            yii\bootstrap\Modal::end();
            ?>

        </div>

        <?php $this->endBody() ?>
    </body>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- datatables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- $script = <<< JS -->

    <script>
        $(document).ready(function() {
            $('#table-index').DataTable();
            $('.datatables').DataTable();
        });
    </script>

    <!-- JS;

$this->registerJs($script); -->

    </html>
    <?php $this->endPage() ?>
<?php } ?>
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
        <link rel="shortcut icon" href="images/pavicon.ico">
        <title><?= Html::encode(Yii::$app->name) ?></title>
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

            .swal2-popup {
                font-size: 1.5rem !important;
            }
        </style>
        <link href='https://fonts.googleapis.com/css?family=Libre Barcode 39' rel='stylesheet'>
        <?php $this->head() ?>
    </head>

    <body class="hold-transition skin-yellow sidebar-mini <?= (Yii::$app->controller->id == 'data-pembelian-barang' || Yii::$app->controller->id == 'data-penjualan-barang') ? 'sidebar-collapse' : 'fixed' ?>">
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
    <!-- <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->

    <!-- $script = <<< JS -->

    <script>
        $(document).ready(function() {
            $('#table-index').DataTable();
            $('.datatables').DataTable();
            $('#pagination').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        });
        $('#tabForRefreshPage li a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#tabForRefreshPage li a[href="' + hash + '"]').tab('show');

        const approver = document.querySelector('.btn-approver-hidden');
        const formUser = document.querySelector('.form-user');
        const btnUbah = document.querySelector('.btn-ubah-hidden');
        const btnHapus = document.querySelector('.btn-hapus-hidden');
        const btnPending = document.querySelector('.btn-pending-hidden');
        const btnHapusDetail = document.querySelector('.btn-hapus-detail');
        const btnUbahDetail = document.querySelector('.btn-ubah-detail');
        if (approver != null) {
            formUser.style.display = "none";
            btnPending.style.display = "none";
            btnHapusDetail.style.display = "none"
            btnUbahDetail.style.display = "none"
        } else {
            btnHapusDetail.style.display = true
            btnUbahDetail.style.display = true
        }
    </script>

    <!-- JS;

$this->registerJs($script); -->

    </html>
    <?php $this->endPage() ?>
<?php } ?>
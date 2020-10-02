<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
    <style type="text/css">
        .login-page {
            background-image: url('images/pst.jpg');
            background-size: cover;
        }

        .swal2-popup {
            font-size: 1.5rem !important;
        }
    </style>
</head>

<body class="login-page">

    <?php //Alert::widget() 
    ?>

    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    <script src="sweetalert2/dist/sweetalert2.all.min.js"></script>
</body>

</html>
<?php $this->endPage() ?>
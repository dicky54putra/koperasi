<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'sweetalert2/dist/sweetalert2.min.css',
        'css/site.css',
        'css/dataTables.bootstrap.min.css',
    ];
    public $js = [
        'sweetalert2/dist/sweetalert2.all.min.js',
        'js/alert.js',
        'js/modal.js',
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap.min.js',
        // 'https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        'js/jquery.slimscroll.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

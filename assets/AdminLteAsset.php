<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css",
        "https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css",
        "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css",
        "/adminlte/css/adminlte.css",
        "https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css",
        "https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css", 
    ];
    public $js = [
        "https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js",
        "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js",
        // "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js",
        "/adminlte/js/adminlte.js",
        "/adminlte/js/scrollbar.js",
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap5\BootstrapAsset'
    ];
}

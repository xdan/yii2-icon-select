<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/17/16
 * Time: 1:50 PM
 */

namespace xdan;


class IconSelectWidgetAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/xdan/yii2-icon-select/src/assets';
    public $js = [
        'js/lib/control/iconselect.js',
        'js/lib/iscroll.js',
    ];
    public $css = [
        'css/lib/control/iconselect.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
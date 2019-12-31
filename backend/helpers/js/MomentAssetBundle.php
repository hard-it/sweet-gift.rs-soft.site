<?php

namespace backend\helpers\js;

use yii\web\AssetBundle as BaseAssetBundle;

/**
 * Class MomentAssetBundle
 * @package backend\helpers\js
 */
class MomentAssetBundle  extends BaseAssetBundle
{
    public $sourcePath = '@bower/moment/min';

    public $js = [
        'moment.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

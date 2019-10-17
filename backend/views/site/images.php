<?php

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->title = 'Изображения';

echo Html::beginTag('div', ['class' => 'elfinder-iframe-container']);
echo Html::beginTag(
    'iframe',
    [
        'src'   => Url::toRoute('/elfinder/manager'),
        'scrolling' => 'no',
        'class' => 'image-manager-iframe',
    ]);
echo Html::endTag('iframe');
echo Html::endTag('div');

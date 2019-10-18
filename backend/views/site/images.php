<?php

use \yii\helpers\Html;
use \yii\helpers\Url;
//use mihaildev\elfinder\ElFinder;
//use yii\web\JsExpression;

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

/*
echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);
*/

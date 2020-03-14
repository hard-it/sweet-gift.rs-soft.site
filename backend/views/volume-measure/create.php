<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VolumeMeasure */

$this->title = Yii::t('app', 'Добавление единицы измерения');

echo Html::beginTag('div', ['class' => 'volume-measure-create']);

echo Html::tag('h1', Html::encode($this->title));

echo $this->render('_form', [
    'model' => $model,
]);

echo Html::endTag('div');

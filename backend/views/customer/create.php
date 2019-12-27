<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = Yii::t('app', 'Добавление заказчика');

echo Html::beginTag('div', ['class' => 'customer-create']);

echo Html::tag('h1', Html::encode($this->title));

echo $this->render('_form', [
    'model' => $model,
]);

echo Html::endTag('div');

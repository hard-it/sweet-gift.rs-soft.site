<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerOrder */

$this->title = Yii::t('app', 'Изменение заказа: #{name}', [
    'name' => $model->Number,
]);

$this->title = Yii::t('app', 'Добавление заказа');

echo Html::beginTag('div', ['class' => 'customer-order-update']);

echo Html::tag('h1', Html::encode($this->title));

echo $this->render('_form', [
    'model' => $model,
]);

echo Html::endTag('div');

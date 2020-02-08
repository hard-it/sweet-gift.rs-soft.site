<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = Yii::t('app', 'Изменение заказчика: {name}', [
    'name' => $model->Firstname . ' ' . $model->Lastname,
]);

echo Html::beginTag('div', ['class' => 'customer-update']);

echo Html::tag('h1', Html::encode($this->title));

echo $this->render('_form', [
    'model' => $model,
]);

echo Html::endTag('div');

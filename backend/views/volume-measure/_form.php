<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\helpers\js\grids\ButtonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\VolumeMeasure */
/* @var $form yii\widgets\ActiveForm */

$buttonHelper = new ButtonHelper($this);

echo Html::beginTag('div', ['class' => ' box box-no-top-border']);

echo Html::beginTag('div', ['class' => 'customer-form']);

$form = ActiveForm::begin();

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-6']);
echo $form->field($model, 'ShortName')->textInput(['maxlength' => true]);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-6']);
echo $form->field($model, 'OneName')->textInput(['maxlength' => true]);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-6']);
echo $form->field($model, 'SomeName')->textInput(['maxlength' => true]);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-6']);
echo $form->field($model, 'ManyName')->textInput(['maxlength' => true]);
echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'form-group']);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-sm-4 col-xs-6']);
echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-lg btn-primary btn-success fa fa-save btn-block btn-flat']);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-sm-4 col-xs-6']);
echo Html::submitButton(Yii::t('app', 'Назад'), ['id'=>'previous-button', 'class' => 'btn btn-lg btn-primary fa fa-undo btn-block btn-flat btn-back']);
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::endTag('div');


ActiveForm::end();

echo Html::endTag('div');
echo Html::endTag('div');

$buttonHelper->registerPreviousMoveScript('previous-button');

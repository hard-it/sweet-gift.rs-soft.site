<?php


use yii\helpers\Html;
use kartik\form\ActiveForm;
use backend\helpers\js\grids\SearchHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */

$jsHelper = new SearchHelper($this);

$this->registerJs($jsHelper->generatePjaxGridReload('pjax-search-form', 'pjax-gridview'));

echo Html::beginTag('div', ['class' => 'customer-search box box-no-top-border']);

Pjax::begin([
    'id'              => 'pjax-search-form',
    'enablePushState' => true,
    'timeout'         => 5000,
]);

$form = ActiveForm::begin([
    'action'  => ['index'],
    'method'  => 'get',
    'options' => [
        'id'        => 'search-form',
        'data-pjax' => 1,
    ],
]);

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'Phone')->widget(PhoneInput::className(), [
    'jsOptions' => [
        'preferredCountries' => ['ru', 'pl', 'ua'],
    ]
]);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'Firstname');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'Lastname');
echo Html::endTag('div');

echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'form-group']);

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-3']);
echo Html::submitButton(Yii::t('app', '<span>Поиск</span>'), ['class' => 'btn btn-lg btn-primary fa fa-search fa-search-button btn-block btn-flat']);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3  col-xs-3']);
echo Html::resetButton(
    Yii::t('app', '<span>Очистить</span>'),
    [
        'id'    => 'reset-form-btn',
        'class' => 'btn btn-lg fa btn-danger fa-refresh fa-refresh-button btn-block btn-flat',
    ]);
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::endTag('div');

$this->registerJs(
    $jsHelper->generatePjaxResetForm(
        'reset-form-btn',
        'pjax-search-form',
        Url::toRoute(['customer/clear-search'])
    ),
    View::POS_READY
);

ActiveForm::end();

Pjax::end();

echo Html::endTag('div');

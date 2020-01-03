<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\tree\TreeViewInput;
use common\models\ProductCategory;
use backend\helpers\js\grids\SearchHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\ProductTypeSearch */
/* @var $form yii\widgets\ActiveForm */

$jsHelper = new SearchHelper($this);

$this->registerJs($jsHelper->generatePjaxGridReload('pjax-search-form', 'pjax-gridview'));

echo Html::beginTag('div', ['class' => 'product-type-search box box-no-top-border']);

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
echo $form->field($model, 'Code');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-8 col-xs-12']);
echo $form->field($model, 'Name');
echo Html::endTag('div');


echo Html::beginTag('div', ['class' => 'col-lg-12 col-xs-12']);
echo $form->field($model, 'Category')->widget(TreeViewInput::classname(),
    [
        'name'           => 'Category',
        'value'          => $model->Category, // preselected values
        'query'          => ProductCategory::find()->addOrderBy('root, lft, Name'),
        'headingOptions' => ['label' => 'Категории'],
        'rootOptions'    => ['label' => 'Все товары'],
        'fontAwesome'    => true,
        'asDropdown'     => true,
        'multiple'       => true,
        'options'        => [
            'disabled' => false,
            'id'       => 'CategoryTree',
        ],
    ]);
echo Html::endTag('div');

echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'form-group']);

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-3']);
echo Html::submitButton(Yii::t('app', '<span>Поиск</span>'), ['class' => 'btn btn-lg btn-primary fa fa-search fa-search-button btn-block btn-flat']);
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3  col-xs-3']);
echo Html::resetButton(
    Yii::t('app', '<span>Очистка</span>'),
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
        Url::toRoute(['product-type/clear-search'])
    ),
    View::POS_READY
);

ActiveForm::end();

Pjax::end();

echo Html::endTag('div');

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;
use common\models\ProductCategory;

/* @var $this yii\web\View */
/* @var $model common\models\ProductTypeSearch */
/* @var $form yii\widgets\ActiveForm */

echo Html::beginTag('div', ['class' => 'product-type-search']);

    $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]);

        echo $form->field($model, 'Code');

        echo $form->field($model, 'Category')->widget(TreeViewInput::classname(),
            [
                'name' => 'Category',
                'value' => 'true', // preselected values
                'query' =>ProductCategory::find()->addOrderBy('root, lft, Name'),
                'headingOptions' => ['label' => 'Категории'],
                'rootOptions' => ['label'=>''],
                'fontAwesome' => true,
                'asDropdown' => true,
                'multiple' => false,
                'options' => [
                    'disabled' => false,
                ],
            ]);

        echo $form->field($model, 'Name');

        echo Html::beginTag('div', ['class' => 'form-group']);

            echo Html::submitButton(Yii::t('app', 'Поиск'), ['class' => 'btn btn-primary']);

            echo Html::resetButton(Yii::t('app', 'Очистить'), ['class' => 'btn btn-outline-secondary']);

        echo Html::endTag('div');

    ActiveForm::end();

echo Html::endTag('div');

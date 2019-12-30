<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use backend\helpers\js\grids\SearchHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;
use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;
use borales\extensions\phoneInput\PhoneInput;
use common\models\CustomerOrderSearch;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerOrderSearch */
/* @var $form yii\widgets\ActiveForm */

$jsHelper = new SearchHelper($this);

$this->registerJs($jsHelper->generatePjaxGridReload('pjax-search-form', 'pjax-gridview'));

echo Html::beginTag('div', ['class' => 'customer-order-search box box-no-top-border']);

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
            echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
                echo $form->field($model, 'Number');
            echo Html::endTag('div');

            echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
                echo $form->field($model, 'RDate')->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'convertFormat' => true,
                    'options' => ['placeholder' => Yii::t('app','Дата заказа')],
                    'pluginOptions' => [
                        'format' => 'dd.MM.yyyy',
                        'autoclose'=>true
                    ]
                ]);
            echo Html::endTag('div');

            echo Html::beginTag('div', ['class' => 'col-lg-6 col-xs-12']);

                echo Html::beginTag('div', ['class' => 'form-group']);
                    echo Html::label(Yii::t('app', 'Время доставки'), 'CustomerOrderSearch[FullTDate]');
                    echo DateRangePicker::widget([
                        'model' => $model,
                        'hideInput' => true,
                        'name'=>'CustomerOrderSearch[FullTDate]',
                        //'useWithAddon'=>true,
                        'convertFormat'=>true,
                        'startAttribute' => 'CustomerOrderSearch[TDate][0]',
                        'endAttribute' => 'CustomerOrderSearch[TDate][1]',
                        'pluginOptions' => [
                            'timePicker' => true,
                            'timePickerIncrement' => 15,
                            'presetDropdown' => true,
                            'locale' => [
                                    'format' => 'd.m.Y H:i',
                                    'cancelLabel' => Yii::t('app', 'Отмена'),
                                ],
                            'showDropdowns' => true,
                            'timePicker24Hour' => true,
                        ]
                    ]);
                echo Html::endTag('div');
            echo Html::endTag('div');



        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'row']);

            echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
                echo $form->field($model, 'Phone')->widget(PhoneInput::className(), [
                    'jsOptions' => [
                        'preferredCountries' => ['ru', 'pl', 'ua'],
                    ]
                ]);
            echo Html::endTag('div');

            echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
                echo $form->field($model, 'Firstname');
            echo Html::endTag('div');

            echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
                echo $form->field($model, 'Lastname');
            echo Html::endTag('div');

            echo Html::beginTag('div', ['class' => 'col-lg-3 col-xs-12']);
                echo $form->field($model, 'StateRange')->dropDownList(CustomerOrderSearch::getStateRangeList());
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
                Url::toRoute(['customer-order/clear-search'])
            ),
            View::POS_READY
        );

        ActiveForm::end();

    Pjax::end();

echo Html::endTag('div');

<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use backend\helpers\js\grids\SearchHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\daterange\DateRangePicker;

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
            /*
echo DateRangePicker::widget([
    'name'=>'TDate',
    //'useWithAddon'=>true,
    'convertFormat'=>true,
    'startAttribute' => 'CustomerOrderSearch[TDate][0]',
    'endAttribute' => 'CustomerOrderSearch[TDate][1]',
    'pluginOptions' => [
        'locale' => ['format' => 'd.m.Y H:i'],
    ]
]);
            /*
                echo DateTimePicker::widget([
                    'model' => $model,
                    'attribute' => 'TDate[0]',
                    'attribute2' => 'TDate[1]',
                    'options' => ['placeholder' => Yii::t('app','От')],
                    'options2' => ['placeholder' => Yii::t('app','До')],
                    'type' => DatePicker::TYPE_RANGE,
                    'form' => $form,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy hh:ii',
                        'autoclose' => true,
                    ]
                ]);

                /*
                echo $form->field($model, 'TDate')->widget(DateTimePicker::classname(), [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'name' => 'TDate[0]',
                    'options' => ['placeholder' => Yii::t('app','Время получения')],
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy hh:ii',
                        'autoclose'=>true
                    ]
                ]);
                */
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

?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'Id') ?>

    <?= $form->field($model, 'Number') ?>

    <?= $form->field($model, 'Customer') ?>

    <?= $form->field($model, 'Sum') ?>

    <?= $form->field($model, 'State') ?>

    <?php // echo $form->field($model, 'OrderPoint') ?>

    <?php // echo $form->field($model, 'OrderPointDescription') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

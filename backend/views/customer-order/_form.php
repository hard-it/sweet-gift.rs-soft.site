<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use backend\helpers\js\grids\ButtonHelper;
use unclead\multipleinput\MultipleInput;
use backend\helpers\js\MultiInputHelper;
use kartik\datetime\DateTimePicker;
use backend\helpers\js\TimeZoneHelper;
use common\models\CustomerOrderState;
use unclead\multipleinput\components\BaseColumn;
use unclead\multipleinput\renderers\BaseRenderer;
use unclead\multipleinput\renderers\DivRenderer;
use common\models\CustomerOrder;
use \kartik\number\NumberControl;
use common\models\OrderProduct;
use kartik\select2\Select2;
use common\models\ProductType;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerOrder */
/* @var $form yii\widgets\ActiveForm */

$buttonHelper = new ButtonHelper($this);

echo Html::beginTag('div', ['class' => ' box box-no-top-border']);

echo Html::beginTag('div', ['class' => 'customer-order-form']);

$form = ActiveForm::begin();

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'Number');
echo Html::endTag('div');

echo Html::endTag('div');


echo Html::beginTag('div', ['class' => 'row']);

echo $form->field($model, 'customer0[Id]')->hiddenInput()->label(false);;

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'customer0[Phone]')->widget(PhoneInput::class, [
    'jsOptions' => [
        'preferredCountries' => ['ru', 'pl', 'ua'],
    ],
])->label(Yii::t('app', 'Телефон'));
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'customer0[Firstname]')->label(Yii::t('app', 'Имя'));;
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'customer0[Lastname]')->label(Yii::t('app', 'Фамилия'));
echo Html::endTag('div');

echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-12 col-lg-12 col-xs-12 margined-multiinput']);
echo $form->field($model, 'productData')->widget(MultipleInput::class, [
    // max images count
    //'max'               => 10,
    // should be at least 2 rows
    //'min'               => 2,
    'rendererClass'     => DivRenderer::class,
    'allowEmptyList'    => true,
    'enableGuessTitle'  => true,
    'cloneButton'       => false,
    'sortable'          => false,
    // show add button in the footer
    'addButtonPosition' => MultipleInput::POS_HEADER,
    'id'                => 'model-products',
    'class'             => 'multiple-input col-md-12 col-xs-12 col-lg-12',
    'columns'           => [

        [
            'name'    => CustomerOrder::ORDER_PRODUCT_PRODUCT_TYPE,
            'type'    => Select2::class,
            'title'   => '',
            'options' => [
                'data'          => ProductType::getFullTree(),
                'pluginOptions' => [
                    'placeholder' => Yii::t('app','Товар...'),
                ],
                'pluginEvents'  => [
                    'select2:select' => 'function() { loadOrderProductCost(this); }',
                ],
                'class'         => 'customer-order-product-id',
            ],
        ],

        [
            'name'         => CustomerOrder::ORDER_PRODUCT_COST,
            'type'         => NumberControl::class,
            'title'        => 'Цена',
            'value'        => function ($data) {
                return $data[CustomerOrder::ORDER_PRODUCT_COST] ?? 0;

            },
            'defaultValue' => 0,
            'options'      => [
                'displayOptions'     => [
                    'placeholder' => Yii::t('app', 'Цена...'),
                    'class'       => 'form-control product-cost',
                ],
                'maskedInputOptions' => [
                    'groupSeparator' => '',
                    'digits'         => 2,
                    'rightAlign'     => true,
                ],
            ],

        ],

        [
            'name'         => CustomerOrder::ORDER_PRODUCT_QUANTITY,
            'type'         => NumberControl::class,
            'title'        => Yii::t('app', 'Количество'),
            'value'        => function ($data) {
                return $data[CustomerOrder::ORDER_PRODUCT_QUANTITY] ?? 0;

            },
            'defaultValue' => 0,
            'options'      => [
                'displayOptions'     => [
                    'class'       => 'form-control product-quantity',
                    'placeholder' => Yii::t('app', 'Количество...'),
                ],
                'maskedInputOptions' => [
                    'groupSeparator' => '',
                    'digits'         => 0,
                    'rightAlign'     => true,
                ],
            ],

        ],

        [
            'name'         => CustomerOrder::ORDER_PRODUCT_SUM,
            'type'         => NumberControl::class,
            'title'        => Yii::t('app', 'Всего'),
            'value'        => function ($data) {
                return $data[CustomerOrder::ORDER_PRODUCT_SUM] ?? 0;

            },
            'defaultValue' => 0,
            'options'      => [
                'readonly'           => true,
                'displayOptions'     => [
                    'class'       => 'form-control product-sum',
                    'placeholder' => Yii::t('app', 'Всего...'),
                ],
                'maskedInputOptions' => [
                    'groupSeparator' => '',
                    'digits'         => 2,
                    'rightAlign'     => true,
                ],
            ],

        ],

        [
            'name'    => CustomerOrder::ORDER_PRODUCT_COMMENT,
            'title'   => Yii::t('app', 'Описание'),
            'options' => [
                'class'       => 'customer-order-product-comment',
                'placeholder' => Yii::t('app', 'Описание'),
            ],

        ],
    ],
    'theme'             => BaseRenderer::THEME_BS,
    'layoutConfig'      => [
        //'offsetClass'       => 'col-xs-offset-0 col-md-offset-0',
        //'wrapperClass'      => 'col-md-10 col-lg-10 col-xs-10 col-xs-offset-0 col-md-offset-0 customer-order-images-wrapper',
        //'buttonAddClass'    => 'col-md-offset-11 col-xs-offset-11 col-lg-offset-11 col-sm-offset-11 customer-order-button-offset-1',
        //'buttonActionClass' => 'col-xs-offset-10 col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-0 customer-order-button-offset',
        'offsetClass'       => 'col-xs-offset-0 col-md-offset-0',
        //'wrapperClass'      => 'col-10 col-md-10 col-lg-10 col-xs-10 col-xs-offset-0 col-md-offset-0 node-images-wrapper',
        'wrapperClass'      => 'col-12 col-md-12 col-lg-12 col-xs-12 col-xs-offset-0 col-md-offset-0 node-images-wrapper',
        //'buttonAddClass'    => 'col-md-offset-11 col-xs-offset-11 col-lg-offset-11 col-sm-offset-11 col-1 col-md-1 col-xs-1 col-lg-1 col-sm-1',
        'buttonAddClass'    => 'col-md-offset-12 col-xs-offset-12 col-lg-offset-12 col-sm-offset-12 col-1 col-md-1 col-xs-1 col-lg-1 col-sm-1 customer-order-add-product-button',
        //'buttonActionClass' => 'col-xs-offset-10 col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-0 image-button-offset-1',
        'buttonActionClass' => 'col-xs-offset-12 col-lg-offset-12 col-md-offset-12 col-sm-offset-12 col-xs-0 image-button-offset-1',
    ],

    'rowOptions' => [
        //'class' => 'col-md-12 col-lg-12 col-xs-12 col-xs-offset-0',
        //'class' => 'col-11 col-md-11 col-lg-11 col-xs-11 col-xs-offset-0 order-product-item',
        'class' => 'col-md-5 col-lg-3 col-xs-12 col-xs-offset-0 col-lg-offset-1 col-md-offset-1 order-product-item',
    ],

]);
echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-12 col-lg-12 col-xs-12 margined-multiinput']);
echo $form->field($model, 'State')->widget(MultipleInput::class, [
    // max images count
    //'max'               => 10,
    // should be at least 2 rows
    //'min'               => 2,
    'rendererClass'     => DivRenderer::class,
    'allowEmptyList'    => false,
    'enableGuessTitle'  => true,
    'cloneButton'       => false,
    'sortable'          => false,
    // show add button in the footer
    'addButtonPosition' => MultipleInput::POS_HEADER,
    'id'                => 'model-states',
    'class'             => 'multiple-input col-md-12 col-xs-12 col-lg-12',
    'columns'           => [
        [
            'name'    => CustomerOrderState::ORDER_FIELD_AT,
            'type'    => DateTimePicker::class,
            'value'   => function ($data) {
                return TimeZoneHelper::buildTime(TimeZoneHelper::TIME_ZONE_COOKIE, (int)$data[CustomerOrderState::ORDER_FIELD_AT], 'd.m.Y H:i');
            },
            'options' => [
                'type'          => DateTimePicker::TYPE_COMPONENT_APPEND,
                'convertFormat' => true,
                'pluginOptions' => [
                    'timePicker'          => true,
                    'timePickerIncrement' => 15,
                    'presetDropdown'      => true,
                    'format'              => 'dd.MM.yyyy H:i',
                    'autoclose'           => true,
                    'showDropdowns'       => true,
                    'timePicker24Hour'    => true,
                ],
            ],

        ],

        [
            'name'         => CustomerOrderState::ORDER_FIELD_STATE,
            'type'         => BaseColumn::TYPE_DROPDOWN,
            'items'        => CustomerOrderState::getStatesList(),
            'defaultValue' => CustomerOrderState::ORDER_STATE_CREATED,
            'options'      => [
                'class' => 'customer-order-state-description',

            ],

        ],

        [
            'name'    => CustomerOrderState::ORDER_FIELD_DESCRIPTION,
            'title'   => '',
            'options' => [
                'class'       => 'customer-order-state-description',
                'placeholder' => Yii::t('app', 'Описание'),
            ],

        ],
    ],
    'theme'             => BaseRenderer::THEME_BS,
    'layoutConfig'      => [
        'offsetClass'       => 'col-xs-offset-0 col-md-offset-0',
        'wrapperClass'      => 'col-12 col-md-12 col-lg-12 col-xs-12 col-xs-offset-0 col-md-offset-0 node-images-wrapper',
        //'buttonAddClass'    => 'col-md-offset-11 col-xs-offset-11 col-lg-offset-11 col-sm-offset-10 customer-order-button-offset-1',
        'buttonAddClass'    => 'col-md-offset-12 col-xs-offset-12 col-lg-offset-12 col-sm-offset-12 col-1 col-md-1 col-xs-1 col-lg-1 col-sm-1 custumer-order-state-add-button',
        'buttonActionClass' => 'col-xs-offset-12 col-lg-offset-12 col-md-offset-12 col-sm-offset-12 col-xs-0 image-button-offset-1',
    ],

    'rowOptions' => [
        'class' => 'col-md-5 col-lg-3 col-xs-12 col-xs-offset-0 col-lg-offset-1 col-md-offset-1 order-state-item',
    ],

]);

echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div', ['class' => 'form-group']);
echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-sm-4 col-xs-6']);
echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-lg btn-primary btn-success fa fa-save btn-block btn-flat']);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-sm-4 col-xs-6']);
echo Html::submitButton(Yii::t('app', 'Назад'), ['id' => 'previous-button', 'class' => 'btn btn-lg btn-primary fa fa-undo btn-block btn-flat btn-back']);
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::endTag('div');


ActiveForm::end();

echo Html::endTag('div');
echo Html::endTag('div');

$buttonHelper->registerPreviousMoveScript('previous-button');

MultiInputHelper::registerInsertDateTimeValue($this, 'model-states', '.input-group.date > input');

echo Html::script(MultiInputHelper::buildAfterSelectOrderProductCost(2));
echo Html::script(MultiInputHelper::recalcTotals('model-products', 'product-cost', 'product-quantity', 'product-sum', 2));
?>

<div class="customer-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Customer')->textInput() ?>

    <?= $form->field($model, 'Sum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OrderPoint')->textInput() ?>

    <?= $form->field($model, 'OrderPointDescription')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

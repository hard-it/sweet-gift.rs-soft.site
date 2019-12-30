<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use backend\helpers\js\grids\ButtonHelper;
use kartik\date\DatePicker;
//use kartik\datetime\DateTimePicker;


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

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);

//echo Html::beginTag('div', ['class' => 'form-group']);
/*
echo Html::label(Yii::t('app', 'Время доставки'), 'CustomerOrderSearch[FullTDate]');
echo DateTimePicker::widget([
    'model'         => $model,
    'type'          => DateTimePicker::TYPE_COMPONENT_APPEND,
    'name'          => 'CustomerOrder[RDate]',
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
]);
echo Html::endTag('div');
*/
echo $form->field($model, 'RDate')->widget(DatePicker::class, [
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'convertFormat' => true,
    'options' => ['placeholder' => Yii::t('app','Дата заказа')],
    'pluginOptions' => [
        'format' => 'dd.MM.yyyy',
        'autoclose'=>true
    ]
]);

echo Html::endTag('div');

echo Html::endTag('div');


echo Html::beginTag('div', ['class' => 'row']);

echo $form->field($model, 'customer0[Id]')->hiddenInput()->label(false);;

echo Html::beginTag('div', ['class' => 'col-lg-4 col-xs-12']);
echo $form->field($model, 'customer0[Phone]')->widget(PhoneInput::className(), [
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

?>

<div class="customer-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Customer')->textInput() ?>

    <?= $form->field($model, 'Sum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'State')->textInput() ?>

    <?= $form->field($model, 'OrderPoint')->textInput() ?>

    <?= $form->field($model, 'OrderPointDescription')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

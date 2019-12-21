<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use backend\helpers\js\grids\ButtonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$buttonHelper = new ButtonHelper($this);

echo Html::beginTag('div', ['class' => 'customer-form']);

    $form = ActiveForm::begin();

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

$buttonHelper->registerPreviousMoveScript('previous-button');
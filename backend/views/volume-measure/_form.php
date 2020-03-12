<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VolumeMeasure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="volume-measure-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ShortName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OneName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SomeName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Many')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

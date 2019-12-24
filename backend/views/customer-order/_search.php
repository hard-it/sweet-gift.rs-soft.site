<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-order-search">

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

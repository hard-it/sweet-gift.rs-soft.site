<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductType */

$this->title = Yii::t('app', 'Добавление типа продукта');
?>
<div class="product-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

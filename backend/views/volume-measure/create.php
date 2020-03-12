<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VolumeMeasure */

$this->title = Yii::t('app', 'Create Volume Measure');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Volume Measures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="volume-measure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

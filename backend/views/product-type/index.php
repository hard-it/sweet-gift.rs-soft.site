<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tree\TreeViewInput;
use common\models\ProductCategory;
use common\models\ProductType;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Типы продуктов');
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div', ['class' => 'product-type-index']);

echo Html::tag('h1', Html::encode($this->title));

echo $this->render('_search', ['model' => $searchModel]);

echo Html::beginTag('div', ['class' => 'box box-no-top-border']);

Pjax::begin([
    'id'              => 'pjax-gridview',
    'enablePushState' => true,
    'timeout'         => 5000,
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'layout'       => "\n{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered table-hover',
    ],
    'columns'      => [
        [
            'class'          => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'clickable-gridview-column'],
        ],
        [
            'attribute' => 'Code',
            'label'     => Yii::t('app', 'Код'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
        ],
        [
            'label'          => Yii::t('app', 'Категория'),
            'attribute'      => 'category0.Name',
            'contentOptions' => ['class' => 'clickable-gridview-column'],
        ],

        [
            'attribute'      => 'Name',
            'label'          => Yii::t('app', 'Наименование'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
        ],
        [
            'attribute'      => 'MinimalQuantity',
            'label'          => Yii::t('app', 'Мин. кол.'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
        ],
        [
            'attribute'      => 'Cost',
            'label'          => Yii::t('app', 'Цена'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
        ],
        [
            'format' => 'raw',
            'value'  => function ($model) {

                /* @var ProductType $model */
                $update = '';

                $delete = Html::tag('i', '', ['class' => 'fa fa-trash gridview-delete-button', 'data-key' => $model->Id]);

                $div = Html::tag('div', $delete, ['class' => 'gridview-buttons']);

                return $div;
            },
        ],
    ],
]);

Pjax::end();

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-12 col-md-3']);

echo Html::a(Yii::t('app', 'Создать новый тип'),
    ['create'],
    [
        'class' => 'btn btn-lg bg-olive fa fa-plus btn-block btn-flat',
    ]
);
echo Html::endTag('div');
echo Html::endTag('div');


echo Html::endTag('div');

echo Html::endTag('div');

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tree\TreeViewInput;
use common\models\ProductCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Типы продуктов');
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div', ['class' => 'product-type-index']);

echo Html::tag('h1', Html::encode($this->title));

?>
    <?php Pjax::begin(); ?>
    <?php
    echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?php
    echo Html::beginTag('div', ['class' => 'box box-no-top-border']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'tableOptions' => [
            'class' => 'table table-bordered table-hover',
        ],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'      => 'Code',
                'label' => Yii::t('app','Код'),
                //'contentOptions' => ['style' => 'width:3%'],
            ],
            [
                'value'          => function ($model) {

                    /* @var \common\models\ProductType $model */
                    /* @var \common\models\ProductCategory $category */
                    $category = $model->getCategory0()->one();

                    return isset($category) ? $category->Name : '';
                },
                'label' => Yii::t('app','Категория'),
                'attribute'      => 'Category',
                //'contentOptions' => ['style' => 'width:25%'],
                /*
                'filter'         => TreeViewInput::widget(
                    [

                        'model'          => $searchModel,
                        'attribute'      => 'Category',
                        'value'          => $searchModel->Category, // preselected values
                        'query'          => ProductCategory::find()->addOrderBy('root, lft, Name'),
                        'headingOptions' => ['label' => 'Категории'],
                        'rootOptions'    => ['label' => 'Все категории'],
                        'fontAwesome'    => true,
                        'asDropdown'     => true,
                        'multiple'       => true,
                        'options'        => [
                            'disabled' => false,
                        ],
                    ]
                ),*/
            ],
            [
                'attribute'      => 'Name',
                'label' => Yii::t('app','Наименование'),
                //'contentOptions' => ['style' => 'min-width:50%'],
            ],
            [
                'attribute'      => 'MinimalQuantity',
                'label' => Yii::t('app','Мин. кол.'),
                //'contentOptions' => ['style' => 'width:3%'],
            ],
            //'ShelfLife',
            //'Measure',
            [
                'attribute'      => 'Cost',
                'label' => Yii::t('app','Цена'),
                //'contentOptions' => ['style' => 'width:3%'],
            ],
            //'Description:ntext',
            //'Tags',
            //'Keywords',
            //'Images',

            [
                'class'          => 'yii\grid\ActionColumn',
                //'contentOptions' => ['style' => 'width:3%'],
            ],
        ],
    ]);

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-12 col-md-3']);

echo Html::a(Yii::t('app', 'Создать новый тип'),
    ['create'],
    [
        'class' => 'btn btn-lg bg-olive fa fa-plus btn-block btn-flat'
    ]
);
echo Html::endTag('div');
echo Html::endTag('div');


echo Html::endTag('div');

    Pjax::end();

    echo Html::endTag('div');

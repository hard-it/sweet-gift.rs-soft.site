<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tree\TreeViewInput;
use common\models\ProductCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Product Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'tableOptions' => [
            'class' => 'table table-bordered table-hover',
        ],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'      => 'Code',
                'contentOptions' => ['style' => 'width:3%'],
            ],
            [
                'value'          => function ($model) {

                    /* @var \common\models\ProductType $model */
                    /* @var \common\models\ProductCategory $category */
                    $category = $model->getCategory0()->one();

                    return isset($category) ? $category->Name : '';
                },
                'attribute'      => 'Category',
                'contentOptions' => ['style' => 'width:25%'],
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
                ),
            ],
            [
                'attribute'      => 'Name',
                'contentOptions' => ['style' => 'min-width:50%'],
            ],
            [
                'attribute'      => 'MinimalQuantity',
                'contentOptions' => ['style' => 'width:3%'],
            ],
            //'ShelfLife',
            //'Measure',
            [
                'attribute'      => 'Cost',
                'contentOptions' => ['style' => 'width:3%'],
            ],
            //'Description:ntext',
            //'Tags',
            //'Keywords',
            //'Images',

            [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:3%'],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\ProductType;
use backend\helpers\js\grids\ButtonHelper;
use kartik\dialog\DialogAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

DialogAsset::register($this);

$buttonsHelper = new ButtonHelper($this);

$this->title                   = Yii::t('app', 'Типы товаров');
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

$pageSizeContent = Html::beginTag('div', ['class' => 'row']);

$pageSizeContent .= Html::beginTag('div', ['class' => 'col-md-3 col-sm-3 col-xs-3 col-offset-9 col-md-offset-9 col-sm-offset-9 col-xs-offset-9']);

$pageSizeContent .= Html::activeDropDownList(
    $searchModel,
    'pageSize',
    [
        1   => 1,
        5   => 5,
        10  => 10,
        20  => 20,
        25  => 25,
        50  => 50,
        75  => 75,
        100 => 100,
        150 => 150,
        200 => 200,
    ],
    ['class' => 'form-control pager-dropdown']);

$pageSizeContent .= Html::endTag('div');
$pageSizeContent .= Html::endTag('div');

echo GridView::widget([
    'dataProvider'     => $dataProvider,
    //'filterModel'      => $searchModel,
    'layout'           => $pageSizeContent . "\n{items}\n{pager}",
    'filterSelector'   => '#' . Html::getInputId($searchModel, 'pageSize'),
    'tableOptions'     => [
        'class' => 'table table-bordered table-hover',
    ],
    'responsiveWrap'   => false,
    'bootstrap'        => false,
    'perfectScrollbar' => true,
    'resizableColumns' => false,
    'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
    'striped'          => false,
    'columns'          => [
        /*
        [
            'class'          => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'clickable-gridview-column'],
            'headerOptions' => ['class' => 'col-md-1 col-sm-1'],
        ],
        */
        [
            'attribute'      => 'Code',
            'label'          => Yii::t('app', 'Код'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
            'headerOptions'  => ['class' => 'col-1 col-md-1 col-sm-2 col-xs-2'],
            'vAlign'         => GridView::ALIGN_MIDDLE,
        ],
        [
            'label'          => Yii::t('app', 'Категория'),
            'attribute'      => 'category0.Name',
            'contentOptions' => ['class' => 'clickable-gridview-column'],
            'headerOptions'  => ['class' => 'col-3 col-md-3 col-sm-3 col-xs-3'],
            'vAlign'         => GridView::ALIGN_MIDDLE,
        ],

        [
            'attribute'      => 'Name',
            'label'          => Yii::t('app', 'Товар'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
            'headerOptions'  => ['class' => 'col-4 col-md-4 col-sm-4 col-xs-4'],
            'vAlign'         => GridView::ALIGN_MIDDLE,
        ],
        /*
        [
            'attribute'      => 'MinimalQuantity',
            'label'          => Yii::t('app', 'Кол-во'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
            'headerOptions' => ['class' => 'col-2 col-md-2 col-sm-2 col-xs-2'],
            'hAlign'         => GridView::ALIGN_RIGHT,
            'vAlign'         => GridView::ALIGN_MIDDLE,
        ],
        */
        [
            'attribute'      => 'Cost',
            'label'          => Yii::t('app', 'Цена'),
            'contentOptions' => ['class' => 'clickable-gridview-column'],
            'headerOptions'  => ['class' => 'col-2 col-md-2 col-sm-2 col-xs-2'],
            'value'          => function ($model) {
                /* @var ProductType $model */
                return $model->Cost ?? '-.--';
            },
            'hAlign'         => GridView::ALIGN_RIGHT,
            'vAlign'         => GridView::ALIGN_MIDDLE,
        ],
        [
            'format'        => 'raw',
            'value'         => function ($model) {

                /* @var ProductType $model */
                $update = '';

                $delete = Html::tag('i', '', ['class' => 'fa fa-trash gridview-delete-button', 'data-key' => $model->Id]);

                $div = Html::tag('div', $delete, ['class' => 'gridview-buttons']);

                return $div;
            },
            'headerOptions' => ['class' => 'col-1 col-md-1 col-sm-1 col-xs-1'],
            'hAlign'        => GridView::ALIGN_CENTER,
            'vAlign'        => GridView::ALIGN_MIDDLE,
        ],
    ],
    'pager'            => [
        'options'        => ['class' => 'pagination'],
        'firstPageLabel' => Yii::t('app', '«'),
        'lastPageLabel'  => Yii::t('app', '»'),
        'prevPageLabel'  => '‹',
        'nextPageLabel'  => '›',

        'nextPageCssClass'  => 'next',
        'prevPageCssClass'  => 'previous',
        'firstPageCssClass' => 'first',
        'lastPageCssClass'  => 'last',
        'maxButtonCount'    => 10,
    ],
]);

$this->registerJs(
    $buttonsHelper->generateGridButtonScript(
        'clickable-gridview-column',
        Url::toRoute('product-type/update')
    )
);

$this->registerJs(
    $buttonsHelper->generateDeleteGridButtonScript(
        'gridview-delete-button',
        Url::toRoute('product-type/delete'),
        Yii::t('app','Вы действительно хотите удалить данную запись')
    )
);


Pjax::end();

echo Html::beginTag('div', ['class' => 'row']);

echo Html::beginTag('div', ['class' => 'col-3 col-md-3 col-lg-3 col-xs-3']);

echo Html::a(Yii::t('app', 'Создать'),
    ['create'],
    [
        'class' => 'btn-success btn btn-lg btn-primary fa fa-plus btn-block btn-flat',
    ]
);
echo Html::endTag('div');
echo Html::endTag('div');


echo Html::endTag('div');

echo Html::endTag('div');

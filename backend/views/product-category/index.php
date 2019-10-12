<?php
/* @var $this yii\web\View */

use kartik\tree\TreeView;
use common\models\User;
use common\models\ProductCategory;

$this->params['breadcrumbs'][] = 'Категории товаров';

$this->title = 'Категории товаров';

echo TreeView::widget([
    'id'              => 'product-category-tree',
    // single query fetch to render the tree
    'query'           => ProductCategory::find()->addOrderBy('root, lft, Name'),
    //'nodeView'        => '@backend/views/product-category/_form',
    'headingOptions'  => ['label' => 'Категории'],
    'isAdmin'         => User::isAdmin(),                       // optional (toggle to enable admin mode)
    'displayValue'    => 1,                           // initial display value
    'showIDAttribute' => false,
    'softDelete'      => false,                        // normally not needed to change
    'cacheSettings'   => ['enableCache' => false]      // normally not needed to change
]);
/*
$this->registerJs('$("#blog-tree").on(\'treeview.beforeselect\', function(event, key, jqXHR, settings) {
    tinymce.remove();
                        });');

*/

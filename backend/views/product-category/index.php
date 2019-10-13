<?php
/* @var $this yii\web\View */

use kartik\tree\TreeView;
use common\models\User;
use common\models\ProductCategory;
use dosamigos\tinymce\TinyMceAsset;

TinyMceAsset::register($this);

$this->params['breadcrumbs'][] = 'Категории товаров';

$this->title = 'Категории товаров';

echo TreeView::widget([
    'id'               => 'product-category-tree',
    // single query fetch to render the tree
    'query'            => ProductCategory::find()->addOrderBy('root, lft, Name'),
    'nodeView'        => '@app/views/product-category/_form',
    'headingOptions'   => ['label' => 'Категории'],
    'rootOptions'      => ['label' => '<span class="text-primary">Категории</span>'],
    // this will override the headingOptions
    'topRootAsHeading' => true,
    'fontAwesome'      => true,
    // optional (toggle to enable admin mode)
    'isAdmin'          => User::isAdmin(),
    'iconEditSettings' => [
        'show'     => 'list',
        'listData' => [
            'folder' => Yii::t('app', 'Папка'),
            'file'   => Yii::t('app', 'Документ'),
            'gift'   => Yii::t('app', 'Тортик'),
            'bell'   => Yii::t('app', 'Колокольчик'),
        ],
    ],
    // initial display value
    'displayValue'     => 1,
    'showIDAttribute'  => false,
    // normally not needed to change
    'softDelete'       => false,
    // normally not needed to change
    'cacheSettings'    => ['enableCache' => false],
]);

$this->registerJs('$("#product-category-tree").on(\'treeview:beforeselect\', function(event, key, jqXHR, settings) {
        tinymce.remove();
                        });');

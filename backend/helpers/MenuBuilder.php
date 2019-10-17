<?php

namespace backend\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\helpers\ForbiddingController;

class MenuBuilder
{
    /**
     * @return array
     */
    public static function buildGoodsSubMenu()
    {
        $menuItems = [];

        $goodsSubmenu = [];

        if (ForbiddingController::hasAccess('app-backend\product-category\index')) {
            $goodsSubmenu[] = [
                'label' => Yii::t('app', 'Категории товаров'),
                'icon'  => 'folder-o',
                'url'   => Url::toRoute('/product-category/index'),
            ];
        }

        if (ForbiddingController::hasAccess('app-backend\product-type\index')) {
            $goodsSubmenu[] = [
                'label' => Yii::t('app', 'Типы товаров'),
                'icon'  => 'gift',
                'url'   => Url::toRoute('/product-type/index'),
            ];
        }

        if (count($goodsSubmenu)) {
            $menuItems = [
                'label' => Yii::t('app', 'Продукция'),
                'icon'  => 'truck',
                'items' => [],
            ];

            $menuItems['items'] = $goodsSubmenu;
        }

        return $menuItems;
    }

    /**
     * @return array
     */
    public static function buildImagesItem()
    {
        $menuItems = [];

        if (ForbiddingController::hasAccess('app-backend\elfinder\manager')) {
            $menuItems = [
                'label' => Yii::t('app', 'Изображения'),
                'icon'  => 'camera',
                'url'   => Url::toRoute('/site/images'),
            ];
        }

        return $menuItems;
    }
}

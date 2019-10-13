<?php

namespace backend\controllers;

use Yii;
use common\helpers\ForbiddingController;

/**
 * Class ProductCategoryController
 * @package backend\controllers
 */
class ProductCategoryController extends ForbiddingController
{
    /**
     * Показываем дерево категорий продуктов.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}

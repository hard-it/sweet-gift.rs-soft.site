<?php

namespace common\helpers;

use Yii;
use Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Class ForbiddingJsonController
 * @package common\helpers
 */
class ForbiddingJsonController extends BaseController
{
    /**
     * @param $action
     *
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (parent::beforeAction($action)) {
            $check = Yii::$app->id . '\\' . $action->controller->id . '\\' . $action->id;
            if (Yii::$app->user->can($check)) {
                return true;
            } else {
                throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view'  => 'site\error',
            ],
        ];
    }
}

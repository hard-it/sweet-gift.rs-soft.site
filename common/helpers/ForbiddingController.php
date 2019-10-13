<?php

namespace common\helpers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\helpers\rbac\BaseRule;

class ForbiddingController extends Controller
{
    /**
     * @param $action
     *
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        return true;
        if (parent::beforeAction($action)) {
            $check = static::getCurrentPermission();
            $user = Yii::$app->user;
            if ($user->can($check) || static::hasGuestAccess($check)) {
                $identity = $user->identity;
                if ($identity instanceof User) {
                    /* @var User $identity */
                    $url = $identity->getRedirectUrl($check);

                    if (isset($url)) {
                        $this->redirect($url,302)->send();
                    }
                }
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

    /**
     * @return string
     */
    public static function getCurrentPermission()
    {
        return Yii::$app->id . '\\' . Yii::$app->controller->id . '\\' . Yii::$app->controller->action->id;

    }

    /**
     * @param string $check
     *
     * @return bool
     */
    public static function hasGuestAccess(string $check)
    {
        $auth = Yii::$app->authManager;

        $permissions = $auth->getPermissionsByRole(BaseRule::ROLE_GUEST);

        foreach ($permissions as $permission) {
            if ($permission->name == $check) {
                return true;
            }
        }

        return false;

    }

    /**
     * @param string $permission
     *
     * @return bool
     */
    public static function hasAccess(string $permission)
    {
        return true;
        $user = Yii::$app->user;
        return $user->can($permission) || static::hasGuestAccess($permission);
    }
}

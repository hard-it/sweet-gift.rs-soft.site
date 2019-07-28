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
     * @param $check
     *
     * @return bool
     */
    public function checkGuestAccess($check)
    {
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            return false;
        }

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
     * @param $action
     *
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $check = Yii::$app->id . '\\' . $action->controller->id . '\\' . $action->id;
            $user = Yii::$app->user;
            if ($user->can($check) || $this->checkGuestAccess($check)) {
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
}

<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.01.2019
 * Time: 11:16
 */

namespace common\helpers\rbac;

use Yii;
use \yii\rbac\Permission;
use \yii\rbac\Item as Item;

class UserPermission extends Permission
{
    const PERMISSION_USER = 'UserPermission';

    public $name = self::PERMISSION_USER;

    /**
     * @param int|string $userId
     * @param Item       $permission
     * @param array      $params
     *
     * @return bool
     */
    public function execute($userId, $permission, $params): bool
    {
        if (isset(Yii::$app->authManager->getPermissionsByUser($userId)[$permission->name])) {
            return true;
        }

        return false;
    }
}

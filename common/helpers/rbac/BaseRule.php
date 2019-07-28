<?php
/**
 * Created by PhpStorm.
 * User: MAR
 * Date: 12.12.2018
 * Time: 10:42
 */

namespace common\helpers\rbac;

use Yii;
use \yii\rbac\Rule;
use \yii\rbac\Item as Item;


/**
 * Class BaseRule
 * @package common\helpers\rbac
 */
class BaseRule extends Rule
{
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN       = 'admin';
    const ROLE_EDITOR      = 'editor';
    const ROLE_GUIDE       = 'guide';
    const ROLE_AGENT       = 'agent';
    const ROLE_CUSTOMER    = 'customer';
    const ROLE_USER        = 'user';
    const ROLE_GUEST       = 'guest';
    const BLOCK_POSTFIX    = '_not';

    const RULE_SUPER_ADMIN = 'SuperAdminRule';
    const RULE_EDITOR      = 'EditorRule';
    const RULE_GUIDE       = 'GuideRule';
    const RULE_AGENT       = 'AgentRule';
    const RULE_GUEST       = 'GuestRule';
    const RULE_USER        = 'UserRule';

    public $name = self::RULE_SUPER_ADMIN;

    /**
     * @param int|string $userId
     * @param Item       $permission
     * @param array      $params
     *
     * @return bool|int
     */
    public function executeBase($userId, $permission, $params)
    {
        if (Yii::$app->user->can('super_admin')) {
            return 1;
        }

        // при налии блокирующего разрешения у пользователя
        if (Yii::$app->user->can($permission->name . '_not')) {
            return false;
        }

        //Даже у роли admin и manager может быть блокирующее разрешение
        return true;
    }


    /**
     * @param int|string $userId
     * @param Item       $item
     * @param array      $params
     *
     * @return bool
     */
    public function execute($userId, $item, $params)
    {
        $parent = $this->executeBase($userId, $item, $params);

        if ($parent === 1) {
            return true;
        }
        if ($parent == false) {
            return false;
        }
        $roles = Yii::$app->authManager->getRolesByUser($userId);

        $itemType = $item->type ?? 0;

        if ($itemType == 1) {

            if (isset($roles[$item->name])) {
                return true;
            }

            foreach ($roles as $roleName => $role) {

                $children = Yii::$app->authManager->getChildRoles($roleName);

                if (isset($children[$item->name])) {
                    return true;
                }
            }
        }

        foreach ($roles as $roleName => $role) {
            $rules = Yii::$app->authManager->getPermissionsByRole($roleName);
            if (isset($rules[$item->name])) {
                return true;
            }
        }

        return false;
    }
}

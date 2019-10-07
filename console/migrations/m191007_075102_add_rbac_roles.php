<?php

use yii\db\Migration;
use common\helpers\rbac\BaseRule;
use common\helpers\rbac\AdminRule;
use common\helpers\rbac\DeliveryRule;
use common\helpers\rbac\EditorRule;
use common\helpers\rbac\CustomerRule;
use common\helpers\rbac\UserRule;
use common\helpers\rbac\GuestRule;
use common\models\User;

/**
 * Class m191007_075102_add_rbac_roles
 */
class m191007_075102_add_rbac_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $user = User::find()->andWhere(['username' => 'admin'])->one();

        if (!isset($user)) {
            return true;
        }

        $auth->removeAll();

        // RULES
        $auth->removeAllRules();

        $ruleSuperAdmin = new BaseRule();
        $auth->add($ruleSuperAdmin);

        $ruleAdmin = new AdminRule();
        $auth->add($ruleAdmin);

        $ruleEditor = new EditorRule();
        $auth->add($ruleEditor);

        $ruleAgent = new DeliveryRule();
        $auth->add($ruleAgent);

        $ruleCustomer = new CustomerRule();
        $auth->add($ruleCustomer);

        $ruleUser = new UserRule();
        $auth->add($ruleUser);

        $ruleGuest = new GuestRule();
        $auth->add($ruleGuest);

        // ROLES
        $auth->removeAllRoles();

        $roleSuperAdmin = $auth->createRole(BaseRule::ROLE_SUPER_ADMIN);

        $roleSuperAdmin->description = 'Супер пользователь';

        $auth->add($roleSuperAdmin);

        $roleAdmin              = $auth->createRole(BaseRule::ROLE_ADMIN);
        $roleAdmin->description = 'Администратор';
        $roleAdmin->ruleName    = $ruleAdmin->name;
        $auth->add($roleAdmin);

        $roleEditor              = $auth->createRole(BaseRule::ROLE_EDITOR);
        $roleEditor->description = 'Редактор контента';
        $roleEditor->ruleName    = $ruleEditor->name;
        $auth->add($roleEditor);

        $roleAgent              = $auth->createRole(BaseRule::ROLE_DELIVERY);
        $roleAgent->description = 'Доставка';
        $roleAgent->ruleName    = $ruleAgent->name;
        $auth->add($roleAgent);

        $roleCustomer              = $auth->createRole(BaseRule::ROLE_CUSTOMER);
        $roleCustomer->description = 'Клиент';
        $roleCustomer->ruleName    = $ruleCustomer->name;
        $auth->add($roleCustomer);

        $roleUser              = $auth->createRole(BaseRule::ROLE_USER);
        $roleUser->description = 'Авторизованный пользователь';
        $roleUser->ruleName    = $ruleUser->name;
        $auth->add($roleUser);

        $roleGuest              = $auth->createRole(BaseRule::ROLE_GUEST);
        $roleGuest->description = 'Гость';
        $roleGuest->ruleName    = $ruleGuest->name;
        $auth->add($roleGuest);

        $auth->addChild($roleSuperAdmin, $roleAdmin);
        $auth->addChild($roleSuperAdmin, $roleEditor);
        $auth->addChild($roleSuperAdmin, $roleAgent);
        $auth->addChild($roleSuperAdmin, $roleCustomer);
        $auth->addChild($roleSuperAdmin, $roleUser);
        $auth->addChild($roleSuperAdmin, $roleGuest);

        $auth->assign($roleSuperAdmin, $user->id);

        $auth->addChild($roleAdmin, $roleEditor);
        $auth->addChild($roleAdmin, $roleAgent);
        $auth->addChild($roleAdmin, $roleCustomer);
        $auth->addChild($roleAdmin, $roleUser);
        $auth->addChild($roleAdmin, $roleGuest);

        $auth->addChild($roleEditor, $roleUser);
        $auth->addChild($roleEditor, $roleGuest);

        $auth->addChild($roleAgent, $roleUser);
        $auth->addChild($roleAgent, $roleGuest);

        $auth->addChild($roleCustomer, $roleUser);
        $auth->addChild($roleCustomer, $roleGuest);

        // PERMISSIONS
        $auth->removeAllPermissions();

        $permission              = $auth->createPermission('app-backend\site\login');
        $permission->description = 'Страница входа админки';
        $permission->ruleName    = $ruleGuest->name;
        $auth->add($permission);
        $auth->addChild($roleGuest, $permission);

        $permission              = $auth->createPermission('app-backend\site\index');
        $permission->description = 'Индексная страница админки';
        $permission->ruleName    = $ruleUser->name;
        $auth->add($permission);
        $auth->addChild($roleUser, $permission);

        $permission              = $auth->createPermission('app-backend\site\logout');
        $permission->description = 'Страница выхода админки';
        $permission->ruleName    = $ruleUser->name;
        $auth->add($permission);
        $auth->addChild($roleUser, $permission);

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191007_075102_add_rbac_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_075102_add_rbac_roles cannot be reverted.\n";

        return false;
    }
    */
}

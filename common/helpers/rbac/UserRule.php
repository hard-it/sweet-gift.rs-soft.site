<?php
/**
 * Created by PhpStorm.
 * User: MAR
 * Date: 12.12.2018
 * Time: 11:04
 */

namespace common\helpers\rbac;

use \yii\rbac\Rule;
use \yii\rbac\Item as Item;


/**
 * Class UserRule
 * @package common\helpers\rbac
 */
class UserRule extends BaseRule
{
    public $name = BaseRule::RULE_USER;
}

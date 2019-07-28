<?php
/**
 * Created by PhpStorm.
 * User: MAR
 * Date: 12.12.2018
 * Time: 12:14
 */

namespace common\helpers\rbac;

use Yii;
use \yii\rbac\Rule;
use \yii\rbac\Item as Item;


class GuestRule extends BaseRule
{
    public $name = BaseRule::RULE_GUEST;

}

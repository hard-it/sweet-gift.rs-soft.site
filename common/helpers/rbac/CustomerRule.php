<?php
/**
 * Created by PhpStorm.
 * User: MAR
 * Date: 12.12.2018
 * Time: 12:14
 */

namespace common\helpers\rbac;

use \yii\rbac\Rule;
use \yii\rbac\Item as Item;


class CustomerRule extends BaseRule
{
    public $name = BaseRule::RULE_CUSTOMER;
}

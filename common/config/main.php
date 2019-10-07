<?php
return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cart' => [
            'class' => 'devanych\cart\Cart',
            'storageClass' => 'devanych\cart\storage\SessionStorage',
            'calculatorClass' => 'devanych\cart\calculators\SimpleCalculator',
            'params' => [
                'key' => 'cart',
                'expire' => 604800,
                'productClass' => 'common\models\ProductType',
                'productFieldId' => 'Id',
                'productFieldPrice' => 'Cost',
            ],
        ],
        'cache'       => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class'           => 'yii\rbac\DbManager',
            'itemTable'       => 'AuthItem',
            'itemChildTable'  => 'AuthItemChild',
            'assignmentTable' => 'AuthAssignment',
            'ruleTable'       => 'AuthRule',
            'defaultRoles'    => [
                'guest',
            ],
        ],
    ],
];

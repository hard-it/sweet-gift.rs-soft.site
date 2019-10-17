<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-backend',
    'name'                => 'Панель управления',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language'            => 'ru-RU',
    'bootstrap'           => ['log'],
    'modules'             => [
        'treemanager' => [
            'class'           => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
            'dataStructure'   => [
                'keyAttribute'  => 'Id',
                'nameAttribute' => 'Name',
            ],
            'treeEncryptSalt' => '5d95646cbc48343c9531edc114989e60feee568d9b0c3cc3c4a0e9e60ead6564',
        ],
    ],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-backend',
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
            ],
        ],
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'basePath'       => '@app/messages',
                    'sourceLanguage' => 'ru-RU',
                    'fileMap'        => [
                        'app'       => 'app.php',
                        'elfinder'  => 'elfinder.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'controllerMap'       => [

        'elfinder' => [
            'class'            => 'mihaildev\elfinder\Controller',
            //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            // разрешаем радакторам, админам и супер админам
            'access'           => [
                \common\helpers\rbac\BaseRule::ROLE_EDITOR,
                \common\helpers\rbac\BaseRule::ROLE_ADMIN,
                \common\helpers\rbac\BaseRule::ROLE_SUPER_ADMIN,
            ],
            //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'disabledCommands' => ['netmount'],
            // корневые папки
            'roots'            => [
                // общая
                [
                    'baseUrl'  => '@web',
                    'basePath' => '@webroot',
                    'path'     => 'files/global',
                    'name'     => ['category' => 'elfinder', 'message' => 'Общая папка'],
                ],
                // свои для каждого пользователя
                [
                    'class' => 'mihaildev\elfinder\volume\UserPath',
                    'path'  => 'files/user_{id}',
                    'name'  => ['category' => 'elfinder', 'message' => 'Мои изображения'],
                ],
                // изображения категорий товаров
                [
                    'path' => 'files/product_categories',
                    'name' => ['category' => 'elfinder', 'message' => 'Категории продуктов'],
                ],
                // изображения товаров
                [
                    'path' => 'files/products',
                    'name' => ['category' => 'elfinder', 'message' => 'Продукты'],
                ],
                /*
                [
                    'path'   => 'files/some',
                    'name'   => ['category' => 'elfinder', 'message' => 'Some Name'], // Yii::t($category, $message)
                    'access' => ['read' => '*', 'write' => 'UserFilesAccess'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
                ],
                */
            ],
            'watermark'        => [
                'source'         => __DIR__ . '/water-mark.png', // Path to Water mark image
                'marginRight'    => 5,          // Margin right pixel
                'marginBottom'   => 5,          // Margin bottom pixel
                'quality'        => 95,         // JPEG image save quality
                'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                'targetType'     => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200         // Target image minimum pixel size
            ],
        ],
    ],
    'params'              => $params,
];

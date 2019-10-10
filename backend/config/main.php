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
        'imagemanager' => [
            'class'                   => 'gromovfjodor\imagemanager\Module',
            //set accces rules ()
            'canUploadImage'          => true,
            'canRemoveImage'          => function () {
                return true;
            },
            'deleteOriginalAfterEdit' => false, // false: keep original image after edit. true: delete original image after edit
            // Set if blameable behavior is used, if it is, callable function can also be used
            'setBlameableBehavior'    => false,
            //add css files (to use in media manage selector iframe)
            'cssFiles'                => [
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css',
            ],
            'treemanager' =>  [
                'class' => '\kartik\tree\Module',
                // other module settings, refer detailed documentation
            ]

        ],
    ],
    'components'          => [
        'imagemanager' => [
            'class'             => 'gromovfjodor\imagemanager\components\ImageManagerGetPath',
            //set media path (outside the web folder is possible)
            'mediaPath'         => '../../media',
            //path relative web folder. In case of multiple environments (frontend, backend) add more paths
            'cachePath'         => ['assets/images', '../../frontend/web/assets/images'],
            //use filename (seo friendly) for resized images else use a hash
            'useFilename'       => true,
            //show full url (for example in case of a API)
            'absoluteUrl'       => false,
            'databaseComponent' => 'db' // The used database component by the image manager, this defaults to the Yii::$app->db component
        ],
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
    ],
    'params'              => $params,
];

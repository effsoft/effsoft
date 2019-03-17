<?php

$mongodb = require __DIR__ . '/mongodb.php';
$session = require __DIR__ . '/session.php';
$mailer = require __DIR__ . '/mailer.php';
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'effsoft',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'params' => $params,

    'mongodb' => $mongodb,

    'session' => $session,

    'defaultRoute' => 'site/home/index',

    'modules' => [
        'site' => [
            'class' => 'app\modules\site\Module',
        ],
        'passport' => [
            'class' => 'app\modules\passport\Module',
        ],
    ],

    'components' => [

        'request' => [
            'cookieValidationKey' => 'lGvBfgn9v22ba27fr-F7riYWWoYC8A5t',
            'enableCsrfValidation' => true,
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\modules\passport\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => array('passport/login'),
        ],

        'errorHandler' => [
            'errorAction' => 'site/error/index',
        ],

        'mailer' => $mailer ,

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'suffix' => '',
            'rules' => [
                '/' => 'site/home/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],

        'view' => [
            'class' => '\ogheo\htmlcompress\View',
            'compress' => YII_ENV_DEV ? false : true,
            'theme' => [
                'basePath' => '@app/views/' . $params['theme'],
                'baseUrl' => '@web/views/'  . $params['theme'],
                'pathMap' => [
                    '@app/views' => '@app/views/'  . $params['theme'],
                ],
            ],
        ],

        'assetManager' => [
            'appendTimestamp' => true,
//            'linkAssets' => true,
        ],

    ],

];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

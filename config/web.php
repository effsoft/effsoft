<?php

$mongodb = require __DIR__ . '/mongodb.php';
$session = require __DIR__ . '/session.php';
$mailer = require __DIR__ . '/mailer.php';
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'effsoft',
    'name' => 'Effsoft example site',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'defaultRoute' => 'site/home/index',

    'modules' => [
        'site' => [
            'class' => 'effsoft\eff\module\site\Module',
        ],
        'passport' => [
            'class' => 'effsoft\eff\module\passport\Module',
        ],
    ],

    'components' => [

        'mongodb' => $mongodb,

        'session' => $session,

        'request' => [
            'cookieValidationKey' => 'lGvBfgn9v22ba27fr-F7riYWWoYC8A5t',
            'enableCsrfValidation' => true,
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'effsoft\eff\module\passport\models\User',
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
            'suffix' => '.html',
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
                'basePath' => '@app/themes/' . $params['theme'],
                'baseUrl' => '@web/themes/'  . $params['theme'],
                'pathMap' => [
                    '@app/views' => '@app/themes/'  . $params['theme'],
                ],
            ],
        ],

        'assetManager' => [
            'appendTimestamp' => true,
//            'linkAssets' => true,
        ],

    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

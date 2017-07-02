<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'zh-CN',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
    /*    'cache'=>[
           'class' => 'system.caching.CFileCache',
            'directoryLevel' => 2,
        ],*/
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'loginUrl' => ['user/login'],//默认跳转页
            'identityClass' => frontend\models\Member::className(),//实现接口的类
            'enableAutoLogin' => true,//基于cookie自动登录
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [//地址美化
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix'=>'.html',
            'rules' => [
            ],
        ],
        //配置短信组件
        'sms'=>[
                'class' => \frontend\components\Sms::className(),
                'app_key'=>'24478785',
                'app_secret'=>'165b1ebca5b0a9f0418df038b65874e5',
                'sign_name'=>'jw的小网站',
                'temple_code'=>'SMS_71660179',
        ],
        //redis
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],

    ],
    'params' => $params,
];

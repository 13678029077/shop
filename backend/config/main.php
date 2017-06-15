<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language'=>'zh_CN',//设置中文
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'loginUrl' => ['user/login'],//无权限默认tiaozhuan
            //'identityClass' => 'common\models\User',
            'identityClass' => \backend\models\User::className(),
            'enableAutoLogin' => true,//基于cookie自动登录
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        //七牛配置
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'up_host'=>'http://up-z2.qiniu.com',
            'accessKey'=>'6GX6pflkyaH-jaOJya12fIEhZo6I0TGpl_TQ7wGj',
            'secretKey'=>'qnW_O0gIMmma4PCuDbCOhucxYMoHdMRiN48ROog1',
            'bucket'=>'myshop',
            'domain'=>'http://or9ocwffy.bkt.clouddn.com',
        ],

    ],
    'params' => $params,
];

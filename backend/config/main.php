<?php
$params = array_merge(require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php');

return [
   'id' => 'app-backend',
   'name' => 'Admin Panel',
   'basePath' => dirname(__DIR__),
   'controllerNamespace' => 'backend\controllers',
   'bootstrap' => ['log'],
   'modules' => [
      'gridview' =>  [
         'class' => '\kartik\grid\Module'
      ]
   ],
   'components' => [
      'request' => [
         'csrfParam' => '_csrf-backend',
         'baseUrl' => '/admin'
      ],
      'user' => [
         'identityClass' => 'backend\models\Admin',
         'enableAutoLogin' => true,
         'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
         'loginUrl' => ['auth/login']
      ],
      'session' => [
          // this is the name of the session cookie used for login on the backend
         'name' => 'advanced-backend',
      ],
      'formatter' => [
         'dateFormat'     => 'php:d-m-Y',
         'datetimeFormat' => 'php:d-m-Y в H:i:s',
         'timeFormat'     => 'php:H:i:s',
      ],
      /*'log' => [
         'traceLevel' => YII_DEBUG ? 3 : 0,
         'targets' => [
            [
               'class' => 'yii\log\FileTarget',
               'levels' => ['error', 'warning'],
            ],
         ],
      ],*/
      'errorHandler' => [
         'errorAction' => 'site/error',
      ],
      'urlManager' => [
         'enablePrettyUrl' => true,
         'showScriptName' => false,
         'rules' => [],
      ],
   ],
   'params' => $params,
];

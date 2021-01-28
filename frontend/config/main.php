<?php
$params = array_merge(require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php');

return [
   'id' => 'app-foodbud',
   'name' => 'FoodBud',
   'basePath' => dirname(__DIR__),
   'bootstrap' => ['log'],
   'controllerNamespace' => 'frontend\controllers',
   'components' => [
      'request' => [
         'csrfParam' => '_csrf-frontend',
         'baseUrl' => ''
      ],
      'user' => [
         'identityClass' => 'common\models\User',
         'enableAutoLogin' => true,
         'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
         'loginUrl' => ['auth/login']
      ],
      'session' => [
          // this is the name of the session cookie used for login on the frontend
         'name' => 'advanced-frontend',
      ],
      'errorHandler' => [
         'errorAction' => 'site/error',
      ],
      'urlManager' => [
         'enablePrettyUrl' => true,
         'showScriptName' => false,
         'rules' => require __DIR__ . '/urlManager.php',
      ],
   ],
   'params' => $params,
];

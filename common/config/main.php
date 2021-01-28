<?php
return [
   'aliases' => [
      '@bower' => '@vendor/bower-asset',
      '@npm' => '@vendor/npm-asset',
      '@storage' => '@frontend/web/storage',
      '@backendStorage' => '@backend/web/storage',
      '@uploadImgDelivery' => '@storage/delivery',
      '@uploadImgRestaurant' => '@storage/restaurant',
      '@uploadImgRestaurantPlaces' => '@storage/restaurant/places'
   ],
   'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
   'components' => [
      'cache' => [
         'class' => 'yii\caching\FileCache',
      ],
      'log' => [
         'traceLevel' => YII_DEBUG ? 3 : 0,
         'targets' => [
            'file' =>
               [
                  'class' => 'yii\log\FileTarget',
                  'levels' => ['error', 'warning'],
                   'enabled' => false
               ],
            'db' =>
               [
                  'class' => 'yii\log\DbTarget',
                  'levels' => ['error'],
                  'enabled' => true
               ],
         ],
      ],
   ],

];

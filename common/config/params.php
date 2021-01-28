<?php
$host = $_SERVER['HTTP_HOST'] ? 'https://' . $_SERVER['HTTP_HOST'] : '';
$storage = '/storage';
return [
   'supportEmail' => 'contact@foodbud.co',
   'user.passwordResetTokenExpire' => 3600,
   'user.passwordMinLength' => 6,
   'google_api_key' => 'AIzaSyAdb-hbS3lu3mWtnAELNt8ZaejMPvw3cFE',
   'digger_ids' => [
      19484, // Deliveroo
      19485, // Menulog
      19451 // Ubereats
   ],
   'frontend_url' => $host,
   'backend_url' => $host . '/admin',
   'img_user' => $host . $storage . '/users/',
   'img_restaurant' => $host . $storage . '/restaurant/',
   'img_restaurant_places' => $host . $storage . '/restaurant/places/',
   'img_delivery' => $host . $storage . '/delivery/',
   'img_platform' => $host . $storage . '/platforms/',
   'img_categories' => $host . $storage . '/categories/',
   'img_support' => $host . '/admin' . $storage . '/support/',
];

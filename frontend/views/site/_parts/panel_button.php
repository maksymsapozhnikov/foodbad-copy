<?php

use yii\helpers\Url;
use yii\helpers\Html;
/** @var $item \common\models\CuisineTypes */

?>

<div class="footer-nav-bar">
   <ul class="nav nav-bar">
      <li class="nav-item">
         <a class="nav-link get-category" href="<?= Url::to(['site/index','category' => 'favourites']) ?>">
            <figure>
               <p class="default-item-wrapper favourite-bg">
                  <svg width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M19.9167 3.2301C19.122 1.68255 17.6403 0.603734 15.9235 0.322693C14.2067 0.041652 12.4583 0.59171 11.2117 1.8051L10.5 2.45594L9.81084 1.82844C8.56649 0.590922 6.80116 0.0304113 5.07084 0.323436C3.35056 0.59165 1.86557 1.67382 1.08334 3.22927C0.0257495 5.30182 0.433831 7.8208 2.09168 9.45344L9.90251 17.5001C10.0594 17.6615 10.2749 17.7525 10.5 17.7525C10.7251 17.7525 10.9406 17.6615 11.0975 17.5001L18.8975 9.46844C20.5622 7.83419 20.9747 5.30915 19.9167 3.2301Z" fill="#B34368"/>
                  </svg>
               </p>
               <figurecaption>
                  Favourites
               </figurecaption>
            </figure>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link get-category" href="<?= Url::to(['site/index','category' => 'all']) ?>">
            <figure>
               <p class="default-item-wrapper">
                  <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.5 2.29761C0.5 1.46918 1.17157 0.797607 2 0.797607H8.16667C8.99509 0.797607 9.66667 1.46918 9.66667 2.29761V8.09761C9.66667 8.92603 8.99509 9.59761 8.16667 9.59761H2C1.17157 9.59761 0.5 8.92603 0.5 8.09761V2.29761Z" fill="#859A96"/>
                     <path d="M11.3333 2.29761C11.3333 1.46918 12.0049 0.797607 12.8333 0.797607H19C19.8284 0.797607 20.5 1.46918 20.5 2.29761V8.09761C20.5 8.92603 19.8284 9.59761 19 9.59761H12.8333C12.0049 9.59761 11.3333 8.92603 11.3333 8.09761V2.29761Z" fill="#859A96"/>
                     <path d="M0.5 12.6975C0.5 11.8691 1.17157 11.1975 2 11.1975H8.16667C8.99509 11.1975 9.66667 11.8691 9.66667 12.6975V18.4975C9.66667 19.3259 8.99509 19.9975 8.16667 19.9975H2C1.17157 19.9975 0.5 19.3259 0.5 18.4975V12.6975Z" fill="#859A96"/>
                     <path d="M11.3333 12.6975C11.3333 11.8691 12.0049 11.1975 12.8333 11.1975H19C19.8284 11.1975 20.5 11.8691 20.5 12.6975V18.4975C20.5 19.3259 19.8284 19.9975 19 19.9975H12.8333C12.0049 19.9975 11.3333 19.3259 11.3333 18.4975V12.6975Z" fill="#859A96"/>
                  </svg>
               </p>
               <figurecaption>
                  All
               </figurecaption>
            </figure>
         </a>
      </li>
       <?php if (!empty($cuisineList)): ?>
           <?php foreach ($cuisineList as $item): ?>
             <li class="nav-item">
                <a class="nav-link get-category" href="<?= Url::to(['site/index','category' => $item->id]) ?>">
                   <figure>
                      <p class="default-item-wrapper">
                          <?php
                          $imgUrl = (!empty($item->image) && is_file(Yii::getAlias('@storage') . '/categories/' . $item->image)) ? Yii::$app->params['img_categories'] . $item->image : null;
                          echo $imgUrl ? Html::img($imgUrl) : '';
                          ?>
                      </p>
                      <figurecaption>
                          <?= $item->title ?>
                      </figurecaption>
                   </figure>
                </a>
             </li>
           <?php endforeach; ?>
       <?php endif; ?>
   </ul>
</div>


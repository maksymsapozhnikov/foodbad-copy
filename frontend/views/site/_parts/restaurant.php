<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var \common\models\Restaurant $model */
$showPill = false;
$cuisine = [];
$rating = 0;
$rating_i = 0;
$is_favorite = in_array($model->id, $favorites) ? true : false;
$image = (!empty($model->image) && is_file(Yii::getAlias('@storage') . '/restaurant/' . $model->image)) ? Yii::$app->params['img_restaurant'] . $model->image : 'images/restaurant.jpg';
if (!empty($model->deliveries)) {
    foreach ($model->deliveries as $delivery) {
        /* rating */
        if ($delivery->rating) {
            $rating += ($delivery->rating > 5) ? $delivery->rating - 1 : $delivery->rating;
            $rating_i++;
        }
    }
    $rating = ($rating) ? $rating / $rating_i : 0;
}
if (!empty($category) && ($category == 'all' || $category == 'favourites')) {
    $showPill = true;
    $cuisine = $model->categories($model->deliveries ?? [], $cuisines);
}
?>

<div class="card card-options">
    <a href="#">
        <div class="card-img card-img-options lazy" data-src="<?= $image ?>"></div>
    </a>
    <div class="card-img-overlay bot-50 overlay-option">
        <?php if ($showPill && $cuisine != []): ?>
            <a class="card-btn-pill" href="<?= Url::to('/cuisine/' . $cuisine['id']) ?>">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99999 13.7083C3.29508 13.7083 0.291656 10.7049 0.291656 6.99996C0.295836 3.29678 3.29681 0.295805 6.99999 0.291626C10.7049 0.291626 13.7083 3.29505 13.7083 6.99996C13.7083 10.7049 10.7049 13.7083 6.99999 13.7083ZM3.79166 6.12496C3.46949 6.12496 3.20832 6.38613 3.20832 6.70829V7.29163C3.20832 7.61379 3.46949 7.87496 3.79166 7.87496H5.97916C6.0597 7.87496 6.12499 7.94025 6.12499 8.02079V10.2083C6.12499 10.5305 6.38616 10.7916 6.70832 10.7916H7.29166C7.61382 10.7916 7.87499 10.5305 7.87499 10.2083V8.02079C7.87499 7.94025 7.94028 7.87496 8.02082 7.87496H10.2083C10.5305 7.87496 10.7917 7.61379 10.7917 7.29163V6.70829C10.7917 6.38613 10.5305 6.12496 10.2083 6.12496H8.02082C7.94028 6.12496 7.87499 6.05967 7.87499 5.97913V3.79163C7.87499 3.46946 7.61382 3.20829 7.29166 3.20829H6.70832C6.38616 3.20829 6.12499 3.46946 6.12499 3.79163V5.97913C6.12499 6.05967 6.0597 6.12496 5.97916 6.12496H3.79166Z" fill="white"/>
                </svg>
                <span class="filter-item-text"><?= $cuisine['title'] ?></span>
            </a>
        <?php else: ?>
            <div class="empty"></div>
        <?php endif; ?>
        <a class="like-btn" data-id="<?= $model->id ?>" href="#">
         <span class="<?= $is_favorite ? 'like-svg' : '' ?>">
            <svg width="36" height="34" viewBox="0 0 36 34" opacity="0.7" fill="none" xmlns="http://www.w3.org/2000/svg">
               <g><path d="M27.4167 10.23C26.622 8.68243 25.1403 7.60361 23.4235 7.32257C21.7067 7.04153 19.9583 7.59159 18.7117 8.80498L18 9.45581L17.3108 8.82831C16.0665 7.5908 14.3012 7.03029 12.5708 7.32331C10.8506 7.59153 9.36557 8.6737 8.58334 10.2291C7.52575 12.3017 7.93383 14.8207 9.59168 16.4533L17.4025 24.5C17.5594 24.6614 17.7749 24.7524 18 24.7524C18.2251 24.7524 18.4406 24.6614 18.5975 24.5L26.3975 16.4683C28.0622 14.8341 28.4747 12.309 27.4167 10.23Z" fill="#859A96"/></g>
            </svg>
         </span>
        </a>
    </div>
    <div class="card-body">
        <div class="product-primary-info">
            <a href="<?= Url::to(['site/restaurant-details', 'id' => $model->id]) ?>" class="product-name-card"><?= $model->title ?></a>
            <div class="product-rating">
                <span><?= $model->priceLevel() ?></span>
                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0L10.3982 4.69921L15.6085 5.52786L11.8803 9.26079L12.7023 14.4721L8 12.08L3.29772 14.4721L4.11969 9.26079L0.391548 5.52786L5.60184 4.69921L8 0Z" fill="#FFD463"/>
                </svg>
                <span><?= round($rating, 1) ?></span>
            </div>
        </div>
        <div class="product-secondary-info">
            <?php if (!empty($model->deliveries)): ?>
                <?php foreach ($model->deliveries as $delivery): ?>
                    <a href="<?= $delivery->clean_link ?>" target="_blank" class="link-delivery" data-pjax="0" data-id="<?= $delivery->id ?>">
                        <div class="product-service">
                            <?php $imgUrl = (!empty($delivery->platform->image) && is_file(Yii::getAlias('@storage') . '/platforms/' . $delivery->platform->image)) ? Yii::$app->params['img_platform'] . $delivery->platform->image : null; ?>
                            <?= $imgUrl ? Html::img($imgUrl) : '' ?>
                            <span class="product-price"><?= $delivery->delivery_fee ? '$' . $delivery->delivery_fee : '' ?></span>
                            <span class="product-range"><?= $delivery->average_delivery_time ?>m</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model \common\models\Restaurant
 * @var $this \yii\web\View
 */
$this->title = 'FoodBud | ' . ucwords(Html::encode($model->title));
$this->registerJsFile('/plugins/slick/slick.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerCssFile('/plugins/slick/slick.css');
$this->registerCssFile('/plugins/slick/slick-theme.css');

$rating = 0;
$rating_i = 0;
$is_favorite = !empty($model->favoriteWithUser[0]) ? true : false;
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
?>
<section class="gallery-product">
    <div class="card card-options">
        <div id="gallery-slider" class="gallery-slider">
            <div class="slide-item" style="background-image: url('<?= $image ?>')"></div>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <?php if (is_file(Yii::getAlias('@uploadImgRestaurantPlaces') . DIRECTORY_SEPARATOR . $model->id . DIRECTORY_SEPARATOR . $image->image)): ?>
                        <div class="slide-item" style="background-image: url('<?= Yii::$app->params['img_restaurant_places'] . $model->id . '/' . $image->image ?>')"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="card-img-overlay bot-25 result-overlay-detail">
            <div class="button-and-wrapper">
                <a class="back-btn" href="<?= (!empty($return)) ? $return : Url::to(['index']) ?>">
                    <svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.500002 11.52C0.499183 10.8848 0.783393 10.28 1.28 9.86016L12.432 0.441598C13.2006 -0.177534 14.3435 -0.0943976 15.0061 0.628846C15.6687 1.35209 15.6088 2.45089 14.871 3.10368L5.119 11.3395C5.06485 11.3851 5.03379 11.4509 5.03379 11.52C5.03379 11.5891 5.06485 11.6549 5.119 11.7005L14.871 19.9363C15.3843 20.3498 15.6241 20.9978 15.4975 21.6296C15.3709 22.2613 14.8978 22.7776 14.2613 22.9788C13.6248 23.18 12.9247 23.0344 12.432 22.5984L1.284 13.1827C0.786191 12.7622 0.500631 12.1566 0.500002 11.52Z" fill="white"/>
                    </svg>
                </a>
                <div class="button-wrapper"></div>
            </div>
            <div class="button-and-wrapper">
                <a class="like-product" href="#" data-id="<?= $model->id ?>">
                        <span class="<?= $is_favorite ? 'like-svg' : '' ?>">
                             <svg width="40" height="38" viewBox="0 0 40 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M31.3 11.076C30.3464 9.21891 28.5683 7.92433 26.5082 7.58709C24.448 7.24984 22.35 7.90991 20.854 9.36598L20 10.147L19.173 9.39398C17.6798 7.90896 15.5614 7.23635 13.485 7.58798C11.4207 7.90983 9.63866 9.20844 8.69999 11.075C7.43088 13.562 7.92057 16.5848 9.90999 18.544L19.283 28.2C19.4713 28.3936 19.7299 28.5029 20 28.5029C20.2701 28.5029 20.5287 28.3936 20.717 28.2L30.077 18.562C32.0746 16.6009 32.5696 13.5708 31.3 11.076Z" fill="#859A96"/>
                            </g>
                        </svg>
                        </span>
                </a>
                <div class="button-wrapper">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-description">
    <div class="container">
        <p class="product-name"><?= $model->title ?></p>
        <div class="product-info">
                <span class="">
                     <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 7C0 3.13401 3.13401 0 7 0C8.85651 0 10.637 0.737498 11.9497 2.05025C13.2625 3.36301 14 5.14348 14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7ZM7.72917 10.9871C7.72924 10.9146 7.78232 10.8531 7.854 10.8424V10.843C8.79796 10.7084 9.53322 9.95549 9.64542 9.00861C9.75762 8.06172 9.21869 7.15784 8.33233 6.80633L6.209 5.95642C5.91825 5.84085 5.75069 5.53493 5.80986 5.2277C5.86902 4.92047 6.13821 4.69866 6.45108 4.69933H8.54408C8.94679 4.69933 9.27325 4.37287 9.27325 3.97017C9.27325 3.56746 8.94679 3.241 8.54408 3.241H7.875C7.79446 3.241 7.72917 3.17571 7.72917 3.09517V2.68333C7.72917 2.28063 7.40271 1.95417 7 1.95417C6.59729 1.95417 6.27083 2.28063 6.27083 2.68333V3.12958C6.27072 3.20193 6.21759 3.26325 6.146 3.27367C5.20204 3.40828 4.46678 4.16117 4.35458 5.10806C4.24238 6.05495 4.78131 6.95883 5.66767 7.31033L7.791 8.16025C8.08122 8.27637 8.24823 8.58207 8.18915 8.88902C8.13006 9.19597 7.8615 9.41783 7.54892 9.41792H5.45592C5.05321 9.41792 4.72675 9.74438 4.72675 10.1471C4.72675 10.5498 5.05321 10.8763 5.45592 10.8763H6.125C6.16372 10.8761 6.20091 10.8914 6.22829 10.9188C6.25567 10.9462 6.27099 10.9834 6.27083 11.0221V11.4333C6.27083 11.836 6.59729 12.1625 7 12.1625C7.40271 12.1625 7.72917 11.836 7.72917 11.4333V10.9871Z" fill="#859A96"/>
                    </svg>
                </span>
            <span class="info-text"><?= $model->priceLevel() ?> </span>
            <span class="m-l-10">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7404 5.09193C13.6128 4.74912 13.2861 4.52134 12.9203 4.52026H9.36953C9.2457 4.52035 9.13531 4.44223 9.09419 4.32543L7.81961 0.712843C7.69176 0.370915 7.36507 0.144287 7.00003 0.144287C6.63498 0.144287 6.30829 0.370915 6.18044 0.712843L6.17753 0.722176L4.90586 4.32543C4.86482 4.44203 4.75473 4.5201 4.63111 4.52026H1.07919C0.710903 4.51998 0.381863 4.75035 0.256117 5.09651C0.130371 5.44267 0.234842 5.83051 0.517444 6.06668L3.54144 8.57501C3.63403 8.65184 3.66993 8.77763 3.63186 8.89176L2.36136 12.7015C2.24088 13.063 2.36813 13.4608 2.67601 13.6853C2.98388 13.9097 3.4016 13.9091 3.70886 13.6838L6.82736 11.3972C6.92998 11.322 7.06949 11.322 7.17211 11.3972L10.2894 13.6833C10.5966 13.9093 11.0148 13.9104 11.3231 13.686C11.6314 13.4615 11.7589 13.0633 11.6381 12.7015L10.3676 8.88943C10.3295 8.7753 10.3654 8.64951 10.458 8.57268L13.4879 6.06084C13.7668 5.82272 13.8676 5.43592 13.7404 5.09193Z" fill="#859A96"/>
                    </svg>
                </span>
            <span class="info-text"><?= round($rating, 1) ?></span>
        </div>
        <div class="product-category">
            <ul class="category-list">
                <li class="category-item">
                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.05989 6.51616C4.06779 6.61057 4.1005 6.70151 4.15497 6.78048C4.26423 6.93844 4.33849 7.11629 4.37314 7.30296C4.39706 7.42952 4.83339 7.70056 5.59814 7.77336C5.68434 7.78163 5.76991 7.75269 5.83167 7.69437C5.89343 7.63605 5.92499 7.5544 5.91781 7.47152L5.33739 0.816481C5.33098 0.742536 5.29427 0.674056 5.23531 0.626081C5.17631 0.577755 5.09969 0.553976 5.02239 0.560001L3.85981 0.655201C3.69966 0.66798 3.58046 0.802702 3.59322 0.956481L4.05989 6.51616Z" fill="#859A96"/>
                        <path d="M7.61534 7.3035C7.65097 7.11129 7.7285 6.92847 7.84284 6.76702C7.89986 6.68689 7.93405 6.59384 7.94201 6.4971L8.40868 0.956459C8.41479 0.882329 8.38994 0.808909 8.3396 0.75239C8.28926 0.695871 8.21757 0.660896 8.14034 0.655179L6.97776 0.559979C6.90062 0.553646 6.82402 0.577015 6.76484 0.624939C6.70588 0.672914 6.66916 0.741395 6.66276 0.815339L6.08293 7.47038C6.07568 7.55347 6.1074 7.63534 6.16943 7.6937C6.23147 7.75206 6.31737 7.78085 6.40376 7.77222C7.16034 7.69718 7.59143 7.42838 7.61534 7.3035Z" fill="#859A96"/>
                        <path d="M9.03809 6.15995H9.89151C10.0191 6.15988 10.1318 6.08027 10.1698 5.96339L11.2367 2.68795C11.2847 2.54076 11.1997 2.38402 11.0465 2.33739L9.93409 2.00139C9.8603 1.97892 9.78022 1.98553 9.71151 2.01977C9.64279 2.05401 9.59108 2.11308 9.56776 2.18395L8.27801 6.09835C8.2607 6.15049 8.27662 6.20753 8.31876 6.24438C8.36091 6.28123 8.42155 6.29112 8.47401 6.26971C8.65243 6.19705 8.84429 6.15972 9.03809 6.15995Z" fill="#859A96"/>
                        <path d="M1.83037 5.96339C1.86838 6.08027 1.98108 6.15988 2.10862 6.15995H2.94979C3.14826 6.15981 3.34464 6.19889 3.5267 6.27475C3.57928 6.29733 3.64077 6.28809 3.68364 6.25117C3.72651 6.21425 3.74273 6.15657 3.72504 6.10395L2.43354 2.18395C2.41022 2.11308 2.35851 2.05401 2.28979 2.01977C2.22108 1.98553 2.141 1.97892 2.0672 2.00139L0.954788 2.34019C0.801644 2.38682 0.716617 2.54356 0.764622 2.69075L1.83037 5.96339Z" fill="#859A96"/>
                        <path d="M11.026 7.68208C11.069 7.51815 11.0308 7.34436 10.9225 7.21106C10.8142 7.07777 10.6479 6.99989 10.4718 7H9.03799C8.76138 6.99998 8.52461 7.19046 8.47624 7.45192C8.32516 8.2628 7.08324 8.6324 5.99416 8.6324C4.90508 8.6324 3.66083 8.2628 3.51208 7.45192C3.46367 7.19025 3.22657 6.99971 2.94974 7H1.52758C1.35151 6.99984 1.18523 7.07774 1.07702 7.21107C0.968809 7.3444 0.930786 7.51823 0.973993 7.68208L2.45799 13.384C2.55311 13.747 2.89356 14.001 3.28341 14H8.71657C9.10643 14.001 9.44687 13.747 9.54199 13.384L11.026 7.68208Z" fill="#859A96"/>
                    </svg>
                    <span class="category-name">Fast Food</span>
                </li>
            </ul>
        </div>
        <div class="product-contacts">
            <?= !empty($details['address']) ? '<span class="contacts-item">' . Html::encode($details['address']) . '</span>' : '' ?>
            <?= !empty($details['phone_number']) ? '<span class="contacts-item">' . Html::encode($details['phone_number']) . '</span>' : '' ?>
            <?= !empty($details['website']) ? '<span class="contacts-item">' . Html::encode($details['website']) . '</span>' : '' ?>
        </div>
    </div>
</section>
<section class="product-options">
    <div class="container">
        <span class="product-options__title">Delivery options</span>
    </div>
</section>
<section class="product-options-detail">
    <div class="container">
        <?php if (!empty($model->deliveries)): ?>
            <?php foreach ($model->deliveries as $delivery): ?>
                <a href="<?= $delivery->clean_link ?>" target="_blank" class="link-delivery" data-id="<?= $delivery->id ?>">
                    <div class="product-option-item">
                        <?php $imgUrl = (!empty($delivery->platform->image) && is_file(Yii::getAlias('@storage') . '/platforms/' . $delivery->platform->image)) ? Yii::$app->params['img_platform'] . $delivery->platform->image : null; ?>
                        <?= $imgUrl ? Html::img($imgUrl) : '' ?>
                        <span class="product-price"><?= $delivery->delivery_fee ? '$' . $delivery->delivery_fee : '' ?></span>
                        <span class="product-range"><?= $delivery->average_delivery_time ?>m</span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
<?php if (!empty($details['reviews']) && is_array($details['reviews'])): ?>
    <section class="product-reviews">
        <div class="container">
            <div class="reviews-header">
                <span class="product-reviews__title">Reviews</span>
                <span class="reviews-count"><!--5 Reviews--></span>
            </div>
            <ul class="product-reviews__list">
                <?php foreach ($details['reviews'] as $review): ?>
                    <li class="product-reviews-item">
                        <img src="<?= Html::encode($review['profile_photo_url'] ?? '') ?>" width="40px" height="40px" alt="user-pic">
                        <div class="commentator-info">
                            <div class="commentator-info__header">
                                <span class="commentator-name"><?= Html::encode($review['author_name'] ?? '') ?></span>
                                <span class="time"><?= Html::encode($review['relative_time_description'] ?? '') ?></span>
                            </div>
                            <div class="commentator-info__body">
                                <span class="commentator-comment"><?= Html::encode($review['text'] ?? '') ?></span>
                                <span class="commentator-evaluation">
                                <span class="star">
                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 0L9.09839 4.11181L13.6574 4.83688L10.3953 8.10319L11.1145 12.6631L7 10.57L2.8855 12.6631L3.60473 8.10319L0.342604 4.83688L4.90161 4.11181L7 0Z" fill="#FFD463"/>
                                    </svg>
                                </span>
                                <span class="grade "><?= Html::encode($review['rating'] ?? '') ?></span>
                            </span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif ?>

<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**@var $this \yii\base\View */
$this->title = 'FoodBud | Location';

$this->registerJsFile('@web/js/geo.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?libraries=places&callback=initialize&language=en&key=' . Yii::$app->params['google_api_key'], ['depends' => 'yii\web\YiiAsset']);
?>
<script> var key = '<?= Yii::$app->params['google_api_key'] ?>'</script>
<header class="header">
    <div class="default-header">
        <div class="header-wrapper">
            <a href="<?= (empty(Yii::$app->user->identity->suburb_id)) ? '#' : Url::to(['index']) ?>">
                <svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.500002 12.1736C0.499183 11.5482 0.783393 10.9527 1.28 10.5393L12.432 1.26566C13.2006 0.656053 14.3435 0.73791 15.0061 1.45003C15.6687 2.16214 15.6088 3.24404 14.871 3.88678L5.119 11.9959C5.06485 12.0408 5.03379 12.1056 5.03379 12.1736C5.03379 12.2417 5.06485 12.3065 5.119 12.3513L14.871 20.4605C15.3843 20.8676 15.6241 21.5056 15.4975 22.1276C15.3709 22.7497 14.8978 23.2581 14.2613 23.4561C13.6248 23.6542 12.9247 23.5109 12.432 23.0816L1.284 13.8108C0.786191 13.3967 0.500631 12.8004 0.500002 12.1736Z" fill="white"/>
                </svg>
            </a>
            <p class="location-header-title">Your Location</p>
            <a class="btn location-target" onclick='getLocation()'>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 16.5847C14.2091 16.5847 16 14.8214 16 12.6462C16 10.4711 14.2091 8.70776 12 8.70776C9.79086 8.70776 8 10.4711 8 12.6462C8 14.8214 9.79086 16.5847 12 16.5847Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.377 11.6616H23C23.5523 11.6616 24 12.1024 24 12.6462C24 13.19 23.5523 13.6308 23 13.6308H21.377C21.1316 13.6312 20.9228 13.8068 20.884 14.0453C20.2641 17.8221 17.2568 20.7832 13.421 21.3935C13.1787 21.4317 13.0004 21.6373 13 21.8789V23.477C13 24.0208 12.5523 24.4616 12 24.4616C11.4477 24.4616 11 24.0208 11 23.477V21.8789C10.9996 21.6373 10.8213 21.4317 10.579 21.3935C6.74321 20.7832 3.73588 17.8221 3.116 14.0453C3.07723 13.8068 2.86837 13.6312 2.623 13.6308H1C0.447715 13.6308 0 13.19 0 12.6462C0 12.1024 0.447715 11.6616 1 11.6616H2.623C2.86837 11.6612 3.07723 11.4856 3.116 11.2471C3.73588 7.47028 6.74321 4.50921 10.579 3.89887C10.8213 3.8607 10.9996 3.65506 11 3.41346V1.81543C11 1.27164 11.4477 0.830811 12 0.830811C12.5523 0.830811 13 1.27164 13 1.81543V3.41346C13.0004 3.65506 13.1787 3.8607 13.421 3.89887C17.2568 4.50921 20.2641 7.47028 20.884 11.2471C20.9228 11.4856 21.1316 11.6612 21.377 11.6616ZM5 12.6462C5 16.4527 8.13401 19.5385 12 19.5385C15.8642 19.5342 18.9956 16.4509 19 12.6462C19 8.83968 15.866 5.75389 12 5.75389C8.13401 5.75389 5 8.83968 5 12.6462Z" fill="white"/>
                </svg>
            </a>
        </div>
    </div>
</header>
<main class=" main-white">
    <div class="container">
        <div class="location-search ">
            <div class="search-form-group form-group">
                        <span class="search-ico">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0458 12.575L19.4867 18.0159C19.8931 18.4229 19.8931 19.0822 19.4867 19.4892C19.0769 19.8889 18.4231 19.8889 18.0133 19.4892L12.5725 14.0484C9.3331 16.5126 4.73827 16.0456 2.06099 12.9799C-0.616293 9.91415 -0.46037 5.29828 2.41769 2.42021C5.29576 -0.457848 9.91162 -0.613772 12.9773 2.06351C16.0431 4.74079 16.5101 9.33562 14.0458 12.575ZM7.91667 2.29169C4.81006 2.29169 2.29167 4.81009 2.29167 7.91669C2.29534 11.0218 4.81159 13.538 7.91667 13.5417C11.0233 13.5417 13.5417 11.0233 13.5417 7.91669C13.5417 4.81009 11.0233 2.29169 7.91667 2.29169Z" fill="#403519"/>
                            </svg>
                        </span>
                <input class="search-input " id="location-search" name="search" type="search" placeholder="Search your location">
            </div>
        </div>
    </div>
</main>

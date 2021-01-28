<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

?>
   <main class="p-t-30 main-white">
      <div class="container">
         <div class="search ">
            <form action="">
               <div class="search-form-group form-group">
                        <span class="search-ico">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0458 12.575L19.4867 18.0159C19.8931 18.4229 19.8931 19.0822 19.4867 19.4892C19.0769 19.8889 18.4231 19.8889 18.0133 19.4892L12.5725 14.0484C9.3331 16.5126 4.73827 16.0456 2.06099 12.9799C-0.616293 9.91415 -0.46037 5.29828 2.41769 2.42021C5.29576 -0.457848 9.91162 -0.613772 12.9773 2.06351C16.0431 4.74079 16.5101 9.33562 14.0458 12.575ZM7.91667 2.29169C4.81006 2.29169 2.29167 4.81009 2.29167 7.91669C2.29534 11.0218 4.81159 13.538 7.91667 13.5417C11.0233 13.5417 13.5417 11.0233 13.5417 7.91669C13.5417 4.81009 11.0233 2.29169 7.91667 2.29169Z" fill="#403519"/>
                            </svg>
                        </span>
                  <input class="search-input " id="cuisines-search" name="search" type="search" placeholder="I feel like...">
                  <div class="spinner-border search-spinner text-success d-none" role="status">
                     <span class="sr-only">Loading...</span>
                  </div>
               </div>
            </form>
            <a href="<?= Url::to(['index']) ?>" class="close-btn">
               <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.351302 17.1519C-0.117257 17.6207 -0.117078 18.3805 0.351702 18.8491C0.820481 19.3177 1.58034 19.3175 2.0489 18.8487L9.4585 11.4399C9.49602 11.4023 9.54697 11.3811 9.6001 11.3811C9.65323 11.3811 9.70418 11.4023 9.7417 11.4399L17.1513 18.8503C17.4544 19.1535 17.8963 19.2721 18.3104 19.1612C18.7246 19.0503 19.0482 18.7269 19.1592 18.3128C19.2703 17.8987 19.152 17.4567 18.8489 17.1535L11.4401 9.7415C11.4025 9.70398 11.3813 9.65303 11.3813 9.5999C11.3813 9.54677 11.4025 9.49582 11.4401 9.4583L18.8505 2.0487C19.3191 1.57948 19.3185 0.81926 18.8493 0.350701C18.3801 -0.117857 17.6199 -0.11732 17.1513 0.351901L9.7417 7.7599C9.70418 7.79752 9.65323 7.81866 9.6001 7.81866C9.54697 7.81866 9.49602 7.79752 9.4585 7.7599L2.0489 0.351901C1.58034 -0.116878 0.820481 -0.117057 0.351702 0.351501C-0.117078 0.82006 -0.117257 1.57992 0.351302 2.0487L7.7601 9.4583C7.79772 9.49582 7.81886 9.54677 7.81886 9.5999C7.81886 9.65303 7.79772 9.70398 7.7601 9.7415L0.351302 17.1519Z" fill="#403519"/>
               </svg>
            </a>
         </div>
      </div>
      <div class="recently">
         <div class="container">
            <p class="recently-title">Recently</p>
         </div>
      </div>
      <div class="container">
         <div class="search-result" id="search-result">
         </div>
      </div>
   </main>

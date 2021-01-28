<?php

use yii\helpers\Html;

?>

<div class="img-block">
    <div class="request-img-wrap" id="add">
        <div class="request-img add-img">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
                <path d="M464,0H48C21.49,0,0,21.49,0,48v416c0,26.51,21.49,48,48,48h416c26.51,0,48-21.49,48-48V48C512,21.49,490.51,0,464,0zM480,464c0,8.837-7.163,16-16,16H48c-8.837,0-16-7.163-16-16V48c0-8.837,7.163-16,16-16h416c8.837,0,16,7.163,16,16V464z"/>
                <path d="M347.36,276.64c-6.241-6.204-16.319-6.204-22.56,0l-36.8,36.8l-68.64-68.64c-6.241-6.204-16.319-6.204-22.56,0l-112,112c-6.186,6.31-6.087,16.44,0.223,22.626c2.935,2.878,6.866,4.516,10.977,4.574h320c8.836,0.051,16.041-7.07,16.093-15.907c0.025-4.299-1.681-8.426-4.733-11.453L347.36,276.64z"/>
                <circle cx="304" cy="176" r="48"/>
           </svg>
        </div>
        <div class="request-img-title">Select image</div>
    </div>




</div>

<?php
$js = <<<JS
$('#add').on('click',function(e) {
  e.preventDefault();
  if($('.img-block input').length > 6){
    return false;
  }
  
  var id = Date.now();
  $('.img-block').append('<input id="'+ id +'" type="file" name="SupportRequest[uploadImages][]" accept="image/*" style="display:none">');
  $('input#' + id).click();
});

$(document).on('change','.img-block input',function (e) {
  var file = this.files[0];
  var id = this.id;
  var reader  = new FileReader();
  reader.onloadend = function () {
  	$('.img-block').prepend('<div class="request-img-wrap"><div class="request-img preview" style="background-image: url('+ reader.result +')"><div class="remove" data-file="'+ id +'">&times;</div></div><div class="request-img-title">'+ Math.ceil(file.size / 1000) +' Kb</div></div>');
  }
  if (file) {
    reader.readAsDataURL(file);
  } else {
  	 return false;
  }
});

$(document).on('click','.request-img-wrap .remove', function(e) {
  e.preventDefault();
  $('input#' + $(this).attr('data-file')).remove();
  $(this).parents('div.request-img-wrap').remove();
})

JS;
$this->registerJs($js);
?>


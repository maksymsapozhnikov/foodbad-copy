$(document).ready(function () {
    $(function() {
        $('.lazy').lazy();
    });
});

$(document).on('pjax:complete', function() {
    $(function() {
        $('.lazy').lazy();
    });
});

$(document).on('click', '.categories-list .like-btn, .like-product', function (e) {
    e.preventDefault();
    setFavorite($(this).attr('data-id'));
    $(this).find('span').toggleClass('like-svg');
})

$(document).on('click', '.favourites-list .like-btn', function (e) {
    e.preventDefault();
    setFavorite($(this).attr('data-id'));
    $(this).parents('.card').remove();
    $('.category-container span.restaurants-count').text($('.favourites-list .card').length + '  restaurants');
})

function setFavorite (id) {
    $.ajax({
        url: '/site/favorite',
        type: 'post',
        data: {id: id, _csrf: yii.getCsrfToken()}
    })
    return true;
}

/* Slider */

/*
$('.slider-restaurant').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  infinite: true,
  speed: 600,
  dots: false,
  arrows: false,
  cssEase: 'linear',
  infinite: false
})

$('.slider-restaurant').on('afterChange', function (event, slick, currentSlide) {
  var title = $('div.slick-active').find('div.slide-item-wrap').attr('data-title')
  $('div.menu-title span').text(title)
})

$('.slider-restaurant').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
  $('button[data-slide-id]').removeClass('btn btn-success')
  var button = $('button[data-slide-id=' + nextSlide + ']')
  button.addClass('btn btn-success')
  setButtonOffset(button)
})

$('button[data-slide-id]').on('click', function (e) {
  e.preventDefault()
  var id = $(this).attr('data-slide-id')
  $('.slider-restaurant').slick('slickGoTo', id)
})

/!* Favorites *!/
$(document).on('click', 'span.restaurant-favorite', function (e) {
  e.preventDefault();
  var span = $(this);
  var id = span.attr('data-id');
  $.ajax({
    type: 'POST',
    url: 'site/favorite',
    data: {id: id},
    success: function (data) {
      if (data) {
        var section_favorite = $('div[data-title="Favorites"]')
        span.toggleClass('selected')
        if (data == 'add') {
          section_favorite.prepend(span.parents('.content-wrapper').clone())
        } else if (data == 'remove') {
          section_favorite.find('span[data-id="'+ id +'"]').parents('.content-wrapper').remove()
          $('div.content-wrapper span[data-id="'+ id +'"]').removeClass('selected')
        }
      }
    }
  })
})

function setButtonOffset (button) {
  setTimeout(function () {
    var el_width = button.width() + (parseInt(button.css('padding')) * 2) + parseInt(button.css('margin-right'))
    var win_width = $('#container_wrapper').width()
    var off_set = 0
    var next = button.next()
    var prev = button.prev()

    if (next.length > 0 && ($(next).position().left + 10) > win_width) {
      offset = $('div.button-block').scrollLeft() + (el_width * 3)
      $('div.button-block').scrollLeft(offset)
    }

    if (prev.length > 0 && ($(prev).position().left - el_width) < 0) {
      offset = $('div.button-block').scrollLeft() - (el_width * 3)
      $('div.button-block').scrollLeft(offset)
    }
  }, 500)
}

$(document).on('click','a.link-delivery', function (e) {
  $.ajax({
    type:'POST',
    url:'site/save-click',
    data: {id: $(this).attr('data-id'),_csrf:yii.getCsrfToken()}
    });
});
*/

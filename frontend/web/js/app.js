$(document).ready(function () {

    $('.header-button').on('click', function (e) {
        e.preventDefault()
        $('.page-sidebar').addClass('visible')
        $('.page-sidebar').removeClass('no-visible')
        $('.page-sidebar').show()
    })

    $('.settings-btn').on('click', function (e) {
        e.preventDefault()
        $('.page-sidebar').removeClass('visible')
        $('.page-sidebar').addClass('no-visible')
        setTimeout(() => $('.page-sidebar').hide(), 1000)
    })

    $('#first-name').on('change', function (e) {
        let value = $(this).val()
        if (!value) {
            $(this).removeClass('default-input-active')
        } else {
            $(this).addClass('default-input-active')
        }
    })

    $('#last-name').on('change', function (e) {
        let value = $(this).val()
        if (!value) {
            $(this).removeClass('default-input-active')
        } else {
            $(this).addClass('default-input-active')
        }
    })

    $('#email').on('change', function (e) {
        let value = $(this).val()
        if (!value) {
            $(this).removeClass('default-input-active')
        } else {
            $(this).addClass('default-input-active')
        }
    })

    $('#password').on('change', function (e) {
        let value = $(this).val()
        if (!value) {
            $(this).removeClass('default-input-active')
        } else {
            $(this).addClass('default-input-active')
        }
    })

    $('.default-input-password').on('change', function (e) {
        let value = $(this).val()
        if (!value) {
            $('.password-wrapper').addClass('password-inactive')
            $('.password-wrapper').removeClass('password-active')
            $(this).removeClass('default-input-active')
        } else {
            $('.password-wrapper').removeClass('password-inactive')
            $('.password-wrapper').addClass('password-active')
            $(this).addClass('default-input-active')
        }
    })

    $('.password-eye').on('click', function (e) {
        e.preventDefault()
        let open = $(this).find('.password-eye-open')
        let close = $(this).find('.password-eye-close')
        if (open.hasClass('d-none')) {
            $('.default-input-password').prop('type', 'text')
        }
        if (close.hasClass('d-none')) {
            $('.default-input-password').prop('type', 'password')
        }
        $(this).find('span').toggleClass('d-none')
    })

    $('.support-textarea').on('change', function (e) {
        let value = $(this).val()
        if (value) {
            $('.support-button').addClass('support-button-active')
            $('.support-button').prop('disabled', false)
        } else {
            $('.support-button').removeClass('support-button-active')
            $('.support-button').prop('disabled', true)
        }
    })

    let lastY

    $(document).on('scroll', function (e) {
        let currentY = $(window).scrollTop()

        let footer = $('.footer')
        if (currentY > lastY) {
            footer.addClass('footer-down')
            footer.removeClass('footer-up')
        } else if (currentY < lastY) {
            footer.addClass('footer-up')
            footer.removeClass('footer-down')
        }
        lastY = currentY
    })

    var gallerySlider = $('#gallery-slider')
    if (gallerySlider.length != 0) {
        $('#gallery-slider').slick({
            arrow: false,
            slideToShow: 1,
            dots: true,
        })
    }



    $(document).on('click', 'a.link-delivery', function (e) {
        $.ajax({
            type: 'POST',
            url: '/site/save-click',
            data: {id: $(this).attr('data-id'), _csrf: yii.getCsrfToken()}
        })
    })

    $('#search-suburb').keyup(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault()
            if (event.target.value != '') {
                window.location.href = '/delivery-services?suburb=' + event.target.value
            }
        }
    })

    /* Search page */
    $('#cuisines-search').keyup(function (event) {
        var string = $(this).val()
        if (string.length > 1) {
            $.ajax({
                type: 'POST',
                url: '/site/search',
                data: {s: string, _csrf: yii.getCsrfToken()},
                error: function () {},
                success: function (data) {
                    if (data) {
                        $('#search-result').html(renderSerchItems(data))
                    }
                }
            })
        } else {
            $('#search-result').html('')
        }
    })

    function renderSerchItems (data) {
        var items = ''
        if (data.results) {
            $(data.results).map(function (idx, el) {
                if (el.id && el.text) {
                    items += '<a class="search-result-item justify-content-between" href="/index?type=' + el.id + '">\n' +
                      '               <p class="search-result-text">' + el.text + '</p>\n' +
                      '               <div class="result-img">\n' +
                      '                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                      '                     <path d="M5.83325 14.1667L14.1666 5.83337" stroke="#859A96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>\n' +
                      '                     <path d="M5.83325 5.83337H14.1666V14.1667" stroke="#859A96" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>\n' +
                      '                  </svg>\n' +
                      '               </div>\n' +
                      '            </a>'
                }
            })
        }
        return items
    }
})





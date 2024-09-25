;(function ($, window, document, undefined) {
    'use strict';

    $(document).on('click', 'a.backtotop', function (e) {
        $('html, body').animate({scrollTop: 0}, 800);
        e.preventDefault();
    });
    $(document).on('scroll', function () {
        if ($(window).scrollTop() > 200) {
            $('.backtotop').addClass('active');
        } else {
            $('.backtotop').removeClass('active');
        }
    });

    
})(jQuery, window, document);
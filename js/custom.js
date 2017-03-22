/**
 * File custom.js.
 *
 * Theme custom enhancements
 *
 */

jQuery(document).ready(function($) {




    // To style all <select>s
    $('select').selectpicker();

    //sort the navbar so it reacts on hover
    $('.navbar [data-toggle="dropdown"]').bootstrapDropdownHover();
    $('.dropdown').on('hidden.bs.dropdown', function(){
        $('.dropdown > a').blur();
    });

    // Scroll to top
    // Makes scroll to top appear only when user starts to scroll down
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    // Animation for scroll to top
    $('.scroll-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('img').each(function(){
        $(this).addClass(' img-responsive')
        $(this).removeAttr('width')
        $(this).removeAttr('height');
    });

    var bumpIt = function() {
            $('body').css('margin-bottom', $('.site-footer').height());
        },
        didResize = false;

    bumpIt();

    $(window).resize(function() {
        didResize = true;
    });
    setInterval(function() {
        if(didResize) {
            didResize = false;
            bumpIt();
        }
    }, 250);



});
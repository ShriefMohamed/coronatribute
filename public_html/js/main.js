var ShowLoader = function () {
    $(".loader").css({'display':'block'});
    $("#overlayer").css({'display':'block', 'background': 'rgba(0, 0, 0, 0.3)'});
};
var displayError = function(msg) {
        $('.errorModalMessage').html(msg);
        $('#errorModal').modal();

    // $('#errors-div').html();
        /*'<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
        '    <strong style="padding-right: 10px">Error!</strong>'+msg+'  <a href="/index/contact" class="alert-link">Contact Support</a>.\n' +
        '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '        <span aria-hidden="true">&times;</span>\n' +
        '    </button>\n' +
        '</div>'*/
    // );
};
var scrollTo = function(href) {
    $('html, body').stop().animate({
        scrollTop: $(href).offset().top - 150
    }, 1200, 'swing');
};

(function ($) {
    "use strict";

    $(document).ready(function(){
        $(".loader").delay(1000).fadeOut("slow");
        $("#overlayer").delay(1000).fadeOut("slow");

        // TOP Menu Sticky
        $(window).on('scroll', function () {
            var scroll = $(window).scrollTop();
            if (scroll < 300) {
                $("#sticky-header").removeClass("sticky");
                $('#scrollUp').css({'display':'none'})
            } else {
                $("#sticky-header").addClass("sticky");
                $('#scrollUp').css({'display':'block'})
            }
        });

        // mobile_menu
        var menu = $('ul#navigation');
        if(menu.length){
            menu.slicknav({
                prependTo: ".mobile_menu",
                closedSymbol: '+',
                openedSymbol:'-'
            });
            if ($('#loggedin-menu').length) {
                var logged_in = $('#loggedin-menu').clone();
                $('.slicknav_nav').append(logged_in);
            };
        };


        var OnePageNavigation = function() {
            var navToggler = $('.site-menu-toggle');
            $("body").on("click", ".main-menu li a[href^='#'], .smoothscroll[href^='#'], .site-mobile-menu .site-nav-wrap li a", function(e) {
                var $anchor = $(this),
                    hash = this.hash,
                    pathname = window.location.pathname;
                if (pathname === '/' || pathname === '/index' || pathname === '/index/default') {
                    $('html, body').stop().animate({
                        scrollTop: $($anchor.attr('href')).offset().top
                    }, 1200, 'swing', function(){
                        window.location.hash = hash;
                    });
                } else {
                    window.location.hash = hash;
                    window.location.pathname = '/';
                }

                e.preventDefault();
            });
        };
        OnePageNavigation();

        $("body").on("click", ".smoothscroll-link", function(e) {
            scrollTo($(this).attr('href'));
            e.preventDefault();
        });

        if ($('.slider_active').length > 0) {
            $('.slider_active').owlCarousel({
                items: 1,
                loop: true,
                margin: 0,
                autoplay: true,
                navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                    },
                    767: {
                        items: 1
                    },
                    992: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1600: {
                        items: 1
                    }
                }
            });
        }

        if ($('.testmonial_active').length > 0) {
            $('.testmonial_active').owlCarousel({
                loop:true,
                margin:0,
                items:1,
                autoplay:true,
                navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
                nav:false,
                dots:true,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                responsive:{
                    0:{
                        items:1,
                    },
                    767:{
                        items:1,
                    },
                    992:{
                        items:1,
                    },
                    1200:{
                        items:1,
                    },
                    1500:{
                        items:1
                    }
                }
            });
        }

        if ($('.memorial-slider-active').length > 0) {
            $('.memorial-slider-active').owlCarousel({
                loop:true,
                margin:10,
                autoplay:true,
                navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
                nav:true,
                dots:false,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:5,
                        nav:true,
                        loop:false
                    }
                }
            });
        }

        // wow js
        new WOW().init();

        AOS.init({
            duration: 800,
            easing: 'slide',
            once: false
        });

        // scrollIt for smoth scroll
        $.scrollIt({
            upKey: 38,             // key code to navigate to the next section
            downKey: 40,           // key code to navigate to the previous section
            easing: 'linear',      // the easing function for animation
            scrollTime: 600,       // how long (in ms) the animation takes
            activeClass: 'active', // class given to the active nav element
            onPageChange: null,    // function(pageIndex) that is called when page is changed
            topOffset: 0           // offste (in px) for fixed top navigation
        });

        // scrollup bottom to top
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            topDistance: '4500', // Distance from top before showing element (px)
            topSpeed: 300, // Speed back to top (ms)
            animation: 'fade', // Fade, slide, none
            animationInSpeed: 200, // Animation in speed (ms)
            animationOutSpeed: 200, // Animation out speed (ms)
            scrollText: '<i class="fa fa-angle-double-up"></i>', // Text for element
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });

        // Search Toggle
        $("#search_input_box").hide();
        $("#search").on("click", function () {
            $("#search_input_box").slideToggle();
            $("#search_input").focus();
        });
        $("#close_search").on("click", function () {
            $('#search_input_box').slideUp(500);
        });
        // Search Toggle
        $("#search_input_box").hide();
        $("#search_1").on("click", function () {
            $("#search_input_box").slideToggle();
            $("#search_input").focus();
        });


        // Memorial Create & Memorial View
        $(document).on('change', '#relationship', function (e) {
            if ($('#relationship').val() == 'Other') {
                $('#relationship-other').removeClass('hidden');
                $('#relationship-other').attr('required', true);
            } else {
                $('#relationship-other').addClass('hidden');
                $('#relationship-other').removeAttr('required');
            }
        });

        // memorial create & login
        $('#to-login').on("click", function(e) {
            e.preventDefault();
            $("#login-form").fadeIn();
            $("#register-form").hide();
        });
        $('#to-register').on("click", function(e) {
            e.preventDefault();
            $("#login-form").slideUp();
            $("#register-form").fadeIn();
        });
        $('#to-forgot').on("click", function(e) {
            e.preventDefault();
            $("#login-register-container").slideUp();
            $("#forgot-container").fadeIn();
        });
        $('#to-login-register').on("click", function(e) {
            e.preventDefault();
            $("#login-register-container").fadeIn();
            $("#forgot-container").hide();
        });
    });
})(jQuery);	
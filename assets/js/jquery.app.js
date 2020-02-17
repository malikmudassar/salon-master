/**
* Theme: Adminto Admin Template
* Author: Coderthemes
* Module/App: Main Js
*/


!function($) {
    "use strict";

    var Navbar = function() {};

    //navbar - topbar
    Navbar.prototype.init = function () {
      //toggle
      $('.navbar-toggle').on('click', function (event) {
        $(this).toggleClass('open');
        $('#navigation').slideToggle(400);
        $('.cart, .search').removeClass('open');
      });

      $('.navigation-menu>li').slice(-1).addClass('last-elements');

      $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
        if ($(window).width() < 992) {
          e.preventDefault();
          $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
        }
      });

        $(".right-bar-toggle").click(function(){
          
            if ( typeof page !== 'undefined' && page == 'scheduler' ) {
//                $('.side-bar.right-bar').css({
//                    'right' : '0px'
//                });
                $(".right-bar").toggle();
                $(".right-bar").animate({right: '0px'}, 'fast');
            } else {
                $(".right-bar").toggle();
            }
            
            $('.wrapper').toggleClass('right-bar-enabled');
            
        });
        
    },
    //init
    $.Navbar = new Navbar, $.Navbar.Constructor = Navbar
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.Navbar.init()
}(window.jQuery);


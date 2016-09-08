$(document).ready(function () {
    $('.selectpicker').selectpicker();
	
	var maxSlides = 4;
	var widthSlides = 225;
	
	//if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	  if($(window).width() <= 768){
            maxSlides = 3;
      }
      if($(window).width() <= 480){
            maxSlides = 2;
      }
      if($(window).width() <= 380){
            widthSlides = 280;
            maxSlides = 1;
      }
       
	//}
	
    $('.products-list-slider').bxSlider({
        slideWidth: widthSlides
        , minSlides: 1
        , maxSlides: maxSlides
        , moveSlides: 1
        , slideMargin: 10
        , pager: false
    });

    $('.gallery-product .gallery-slider').bxSlider({
        slideWidth: 100
        , minSlides: 1
        , maxSlides: 4
        , moveSlides: 1
        , slideMargin: 10
        , pager: false
    });

    $("#menu-mobile").mmenu({
        extensions: ["pagedim-black"]
    , }, {
        // configuration
        offCanvas: {
            pageSelector: ".site-page"
        }
    });
    var API = $("#menu-mobile").data("mmenu");

    $("#btn-open-menu").click(function () {
        API.open();
    });

    $('.site-nav>ul>li').hover(
        function () {
            cloneSubmenu = $(this).find('ul').clone();
            if (cloneSubmenu.length > 0) {
                $('.nav-sub-holder ul').replaceWith(cloneSubmenu);

                $('.nav-sub-holder').show();
            }

        }
        , function () {
            $('.nav-sub-holder').hide();
        }
    );

    $('.nav-sub-holder').hover(
        function () {
            $(this).show();
        }
        , function () {
            $(this).hide();
        }
    );
	
	$('.dropbtn, .dropdown-content').hover(
		function () {
			$('.user-menu-control').addClass('active');
		}, 
		function () {
			$('.user-menu-control').removeClass('active');
		}
    );
	
	var heightSlide=$('.slider-home-outer').height();
	$('.item-inner').height(heightSlide);
	
	$( ".fixed-bar" ).css( "margin-top", function( index ) {
		return - Math.round($(this).height()/2);
	});
})
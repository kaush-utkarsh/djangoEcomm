function ajaxCompare(url,id){
	url = url.replace("catalog/product_compare/add","ajax/whishlist/compare");
    if (url.indexOf("?")){
        url = url.split("?")[0];
    }
    url += 'isAjax/1/';
    if(window.location.href.match("https://") && !url.match("https://")){
        url = url.replace("http://", "https://");
    }
    if(window.location.href.match("http://") && !url.match("http://")){
        url = url.replace("https://", "http://");
    }

    jQuery('#preloader .loader').fadeIn(300);

	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			//jQuery('#ajax_loading'+id).hide();
			if(data.status == 'ERROR'){
                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);
			}else{

                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);


				if(jQuery('.block-compare').length){
                    jQuery('.block-compare').replaceWith(data.sidebar);
                }

                if(jQuery('header').hasClass('variant4'))
                {
                    jQuery(function ($) {
                        "use strict";
                        var hiddenBut = $('header.variant4 .navbar-secondary-menu .btn-group.btn-hidden'),
                            hiddenWidth = 50,
                            animDiration = 300;
                        hiddenBut.hover(
                            function () {
                                $(this).stop(true, false).animate({'width': $(this).prop('scrollWidth') }, animDiration , function(){ $(this).css({'overflow':'visible'})});

                                $(this).delay(400).queue(function(){
                                    $(this).addClass('open');
                                    $(this).dequeue();
                                });

                            },

                            function () {
                                $(this).stop(true, false).removeClass('open').animate({'width':hiddenWidth}, animDiration, function(){ $(this).css({'overflow':'hidden'})});
                                $(this).removeClass('open')
                            });

                        var searchHidden = $('header.variant4 .navbar-search input.form-control');

                        searchHidden.focus(function(){
                            $(this).parent().parent('.navbar-search').addClass("focus");
                        }).blur(function(){
                                $(this).parent().parent('.navbar-search').removeClass("focus");
                            })
                    });
                }




			}
		}
	});
}

function ajaxWishlist(url,id){
	url = url.replace("wishlist/index","ajax/whishlist");
    if (url.indexOf("?")){
        url = url.split("?")[0];
    }
	url += 'isAjax/1/';
    if(window.location.href.match("https://") && !url.match("https://")){
        url = url.replace("http://", "https://");
    }
    if(window.location.href.match("http://") && !url.match("http://")){
        url = url.replace("https://", "http://");
    }
    jQuery('#preloader .loader').fadeIn(300);
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			//jQuery('#ajax_loading'+id).hide();
			if(data.status == 'ERROR'){
                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);
			}else{
                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);


                if(jQuery('#toplinks')){
                    jQuery('#toplinks').replaceWith(data.toplink);
                }

                if(jQuery('header').hasClass('variant4'))
                {
                    jQuery(function ($) {
                        "use strict";
                        var hiddenBut = $('header.variant4 .navbar-secondary-menu .btn-group.btn-hidden'),
                            hiddenWidth = 50,
                            animDiration = 300;
                        hiddenBut.hover(
                            function () {
                                $(this).stop(true, false).animate({'width': $(this).prop('scrollWidth') }, animDiration , function(){ $(this).css({'overflow':'visible'})});

                                $(this).delay(400).queue(function(){
                                    $(this).addClass('open');
                                    $(this).dequeue();
                                });

                            },

                            function () {
                                $(this).stop(true, false).removeClass('open').animate({'width':hiddenWidth}, animDiration, function(){ $(this).css({'overflow':'hidden'})});
                                $(this).removeClass('open')
                            });

                        var searchHidden = $('header.variant4 .navbar-search input.form-control');

                        searchHidden.focus(function(){
                            $(this).parent().parent('.navbar-search').addClass("focus");
                        }).blur(function(){
                                $(this).parent().parent('.navbar-search').removeClass("focus");
                            })
                    });
                }




                /*if(jQuery('.block-wishlist').length){
                    jQuery('.block-wishlist').replaceWith(data.sidebar);
                }*/
			}
		}
	});
}
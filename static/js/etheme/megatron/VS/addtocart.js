/*jQuery.noConflict();*/

function setAjaxData(data, iframe) {
    if (data.status == 'ERROR') {
        jQuery('#preloader .inside').html(data.message);
        jQuery('#preloader .message').fadeIn(300);

        setTimeout(function() {
            jQuery('#preloader .message').fadeOut();
        }, 3000)
    } else {
        if (jQuery('#shopping_cart')) {
            jQuery('#shopping_cart').replaceWith(data.sidebar);
        }

        if (jQuery('.nav-item.item-04')) {
            jQuery('.nav-item.item-04').html(data.topcart_mobile_block);
        }

        var $mobileNavItems4 = jQuery(".mobile-nav .nav-item.item-04"),
            $mobileNavItemsLinkAll = jQuery(".mobile-nav .nav-item");
        $mobileNavItemsLink4 = jQuery(".nav-item.item-04 > a");
        $mobileNavItemsLink4.each(function() {
            var $this =
                jQuery(this),
                timer;
            $this.bind("click", function(e) {
                e.preventDefault();
                $mobileNavItemsLinkAll.removeClass("active");
                if (!$this.parent().hasClass("active")) {
                    $mobileNavItems4.removeClass("active");
                    $this.parent().addClass("active")
                } else $this.parent().removeClass("active")
            })
        })

        if (jQuery('#toplinks')) {
            jQuery('#toplinks').replaceWith(data.toplink);
        }
        jQuery.fancybox.close();


        jQuery('#preloader .inside').html(data.message);
        jQuery('#preloader .message').fadeIn(300);

        setTimeout(function() {
            jQuery('#preloader .message').fadeOut();
        }, 2300)

        if (jQuery('header').hasClass('variant4')) {
            jQuery(function($) {
                "use strict";
                var hiddenBut = $('header.variant4 .navbar-secondary-menu .btn-group.btn-hidden'),
                    hiddenWidth = 50,
                    animDiration = 300;
                hiddenBut.hover(
                    function() {
                        $(this).stop(true, false).animate({
                            'width': $(this).prop('scrollWidth')
                        }, animDiration, function() {
                            $(this).css({
                                'overflow': 'visible'
                            })
                        });

                        $(this).delay(400).queue(function() {
                            $(this).addClass('open');
                            $(this).dequeue();
                        });
                    },

                    function() {
                        $(this).stop(true, false).removeClass('open').animate({
                            'width': hiddenWidth
                        }, animDiration, function() {
                            $(this).css({
                                'overflow': 'hidden'
                            })
                        });
                        $(this).removeClass('open')
                    });

                var searchHidden = $('header.variant4 .navbar-search input.form-control');

                searchHidden.focus(function() {
                    $(this).parent().parent('.navbar-search').addClass("focus");
                }).blur(function() {
                    $(this).parent().parent('.navbar-search').removeClass("focus");
                })
            });
        }
    }
}

function setLocationAjax(url, id) {
    if (url.indexOf("?")) {
        url = url.split("?")[0];
    }
    url += 'isAjax/1';
    url = url.replace("checkout/cart", "ajax/index");

    if (window.location.href.match("https://") && !url.match("https://")) {
        url = url.replace("http://", "https://");
    }

    if (window.location.href.match("http://") && !url.match("http://")) {
        url = url.replace("https://", "http://");
    }

    jQuery('#preloader .loader').fadeIn(300);

    try {
        jQuery.ajax({
            url: url,
            dataType: 'json',
            success: function(data) {
                jQuery('#preloader .loader').hide();
                setAjaxData(data, false);

            }
        });
    } catch (e) {

    }
}

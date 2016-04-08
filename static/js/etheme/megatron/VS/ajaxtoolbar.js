$jq=jQuery.noConflict();

 // Check setLocation is add product to cart
	// issend Variable check request on send
	var toolbarsend	=	false;
	var toolbarBaseurl	='';
	var ajaxtoolbar	=	function(){
		function lockshowloading(){

            jQuery('#preloader .loader').show();
		}
		return {
			onReady:function(){
				setLocation=function(link){

					if(link.search("limit=")!=-1||link.search("price=")!=-1||link.search("mode=")!=-1||link.search("dir=")!=-1||link.search("order=")!=-1){
						if(toolbarsend==false){
							ajaxtoolbar.onSend(link,'get');
						
						}
					}else{
                        window.location.href=link;
                    }
                    
				};

				$jq('a','.toolbar').click(function(event) {
					link	=	$jq(this).attr('href');

                    if((link.search("mode=")!=-1||link.search("dir=")!=-1||link.search("price=")!=-1||link.search("p=")!=-1)&&(toolbarsend==false)){
						event.preventDefault();
						ajaxtoolbar.onSend(link,'get');
					}

                    return false;
					
				});
				
			},//End onReady
			onSend:function(url,typemethod){
				new Ajax.Request(url,
					{parameters:{ajaxtoolbar:1},
					method:typemethod,
					onLoading:function(cp){
						toolbarsend=true;
						lockshowloading();
					},
					onComplete:function(cp){
						toolbarsend=false;
						if(200!=cp.status){
							return false;
						}else{
							// Get success	
							var list	=	cp.responseJSON;
							$$(".category-products").invoke("replace",list.toolbarlistproduct);
							ajaxtoolbar.onReady();
                            jQuery('.selectpicker').selectpicker({});
                            retinaProducts();


                            if (jQuery("#isotope").length != 0) {

                                jQuery('#sort-by').change(function(){

                                    jQuery('#isotope').isotope({ sortBy : jQuery(this).val() });
                                });

                                jQuery("#isotope").isotope({
                                    masonry: {},
                                    getSortData : {
                                        Name : function ( $elem ) {
                                            return $elem.find('.info a ').text();
                                        },
                                        Price : function ( $elem ) {
                                            return parseFloat( $elem.find('.sort_price').text());
                                        },
                                        Position : function ( $elem ) {
                                            return parseFloat( $elem.find('.sort_price').text());
                                        }
                                    }
                                });
                            }



                            jQuery('#preloader .loader').hide();
                            previewInit();

                            jQuery('.fancybox').fancybox(
                                {
                                    hideOnContentClick : true,
                                    width: 876,
                                    height:450,
                                    margin:0,
                                    padding:0,
                                    autoDimensions: true,
                                    type : 'iframe',
                                    showTitle: false,
                                    scrolling: 'no',

                                    onComplete: function(){
                                        jQuery('#fancybox-frame').load(function () {
                                            jQuery('#fancybox-content').height(jQuery(this).contents().height());
                                            jQuery.fancybox.resize();

                                        });
                                    }
                                }
                            );




						}
					}
				});
			}//End onSend	
		}
	}();
Prototype.Browser.IE?Event.observe(window,"load",function(){ajaxtoolbar.onReady()}):document.observe("dom:loaded",function(){ajaxtoolbar.onReady()});


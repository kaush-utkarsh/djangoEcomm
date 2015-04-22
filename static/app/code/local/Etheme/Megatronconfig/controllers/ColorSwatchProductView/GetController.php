<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 27.06.14
 * Time: 11:06
 * To change this template use File | Settings | File Templates.
 */
require_once 'SMDesign/ColorswatchProductView/controllers/GetController.php';


class Etheme_Megatronconfig_ColorSwatchProductView_GetController extends SMDesign_ColorswatchProductView_GetController {
    function mainImageAction() {

        $selection = Mage::helper('core')->jsonDecode($this->getRequest()->getParam('selection', '[]'));
        $attributeId = $this->getRequest()->getParam('attribute_id');
        $optionId = $this->getRequest()->getParam('option_id');
        $productId = $this->getRequest()->getParam('product_id');
        $imageSelector = $this->getRequest()->getParam('image_selector', '.product-img-box img#image');

        $_product = Mage::getModel('catalog/product')->load($productId);
        if (!$_product->getId()) {
            $this->_forward('noRoute');
            return;
        }

        $selectedAttributeCode = $_product->getTypeInstance(true)->getAttributeById($attributeId, $_product)->getAttributeCode();

        $colorswatch = Mage::getModel('colorswatch/product_swatch')->setProduct($_product);
        $allProducts = $colorswatch->getAllowProducts();

        foreach ($allProducts as $product) {
            if ($product->isSaleable() && $product->getIsInStock()) {
                if (Mage::getModel('colorswatch/attribute_settings')->getConfig($attributeId, 'allow_attribute_to_change_main_image') == 1 ) {
                    if ($product->getData($selectedAttributeCode) == $optionId) {
                        $products[] = $product;
                    }
                } else {
                    $products[] = $product;
                }
            }
        }

        $selected = array();
        foreach ($selection as $key=>$val) {
            if ($val && Mage::getModel('colorswatch/attribute_settings')->getConfig($key, 'allow_attribute_to_change_main_image') == 1) {
                $selected[$key] = $val;
            }
        }

        $allAvialableAttributeCode = $colorswatch->getAllAttributeCodes();
        foreach ($colorswatch->getAllAttributeIds() as $aKey=>$aId) {

            if (!isset($selected[$aId]) && Mage::getModel('colorswatch/attribute_settings')->getConfig($aId, 'allow_attribute_to_change_main_image') == 1) {
                $options = $colorswatch->getAttributeById($aId)->getColorswatchOptions()->getData();
                $optionCount = count($options);
                $optionIndex = 0;

                while ($optionIndex < $optionCount) {
                    $option = $options[$optionIndex];

                    if ($this->productExsist($products, $allAvialableAttributeCode[$aKey], $option['option_id'])) {
                        $selected[$aId] = $option['option_id'];
                        $optionIndex = count($options);
                    }
                    $optionIndex++;
                }
            }

            if (isset($selected[$aId])) {
                foreach ($products as $key=>$simpleProduct) {
                    if ($simpleProduct->getData($allAvialableAttributeCode[$aKey]) != $selected[$aId]) {
                        unset($products[$key]);
                    }
                }
            }
        }

        if (count($selected) == 0) { // not have attribut who is allowed to change image
            echo "SMDesignColorswatchPreloader.removePerload($$('.product-image img')[0]);";
            echo "  //not have allowed attribute to change image.\n";
            exit();
        }

        /*  calculate image sizes */
        if (Mage::getStoreConfig('smdesign_smdzoom/zoom/enabled') && $_product->getData('enable_zoom_plugin') == 1) {
            /* smdzoom plugin installed*/
            $zoomConfig = array();
            $zoomConfig['image_width'] 		= Mage::getStoreConfig('smdesign_smdzoom/zoom/image_width');
            $zoomConfig['image_height'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/image_height');
            $zoomConfig['thumbnail_width'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/thumbnail_width');
            $zoomConfig['thumbnail_height'] = Mage::getStoreConfig('smdesign_smdzoom/zoom/thumbnail_height');
            $zoomConfig['wrapper_width'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/wrapper_width');
            $zoomConfig['wrapper_height'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/wrapper_height');
            $zoomConfig['wrapper_offset_left'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/wrapper_offset_left');
            $zoomConfig['wrapper_offset_top'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/wrapper_offset_top');
            $zoomConfig['zoom_type'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/zoom_type');
            $zoomConfig['zoom_ratio'] 	= intval(Mage::getStoreConfig('smdesign_smdzoom/zoom/zoom_ratio'));
            $zoomConfig['show_zoom_effect'] = Mage::getStoreConfig('smdesign_smdzoom/zoom/show_zoom_effect');
            $zoomConfig['hide_zoom_effect'] = Mage::getStoreConfig('smdesign_smdzoom/zoom/hide_zoom_effect');
            $zoomConfig['show_info_error'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/show_info_error');
            $zoomConfig['more_view'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/more_view_change_main_image');
            $zoomConfig['show_preloader'] 	= Mage::getStoreConfig('smdesign_smdzoom/zoom/show_preloader');

            if ($zoomConfig['zoom_ratio'] == "" || $zoomConfig['zoom_ratio'] == 0 || $zoomConfig['zoom_ratio'] == 1) {
                $zoomConfig['zoom_ratio'] = 2;
            }

            switch ($zoomConfig['zoom_type']){
                default:
                case 0:
                    /* outside */
                    $ratioModifierWidth = 0;
                    $ratioModifierHeight = 0;
                    if ($zoomConfig['image_width'] * $zoomConfig['zoom_ratio'] <= $zoomConfig['wrapper_width']) {
                        $ratioModifierWidth = intval($zoomConfig['wrapper_width'] / ($zoomConfig['image_width'] * $zoomConfig['zoom_ratio']) );
                    }
                    if ($zoomConfig['image_height'] * $zoomConfig['zoom_ratio'] <= $zoomConfig['wrapper_height']) {
                        $ratioModifierHeight = intval($zoomConfig['wrapper_height'] / ($zoomConfig['image_height'] * $zoomConfig['zoom_ratio']) );
                    }
                    $zoomConfig['zoom_ratio'] = $zoomConfig['zoom_ratio'] + max($ratioModifierWidth,$ratioModifierHeight);
                    break;
                case 1:
                    /* inside */
                    $zoomConfig['show_zoom_effect'] = "none";
                    $zoomConfig['hide_zoom_effect'] = "none";
                    $ratioModifierWidth = 0;
                    $ratioModifierHeight = 0;

                    if ($zoomConfig['image_width'] * $zoomConfig['zoom_ratio'] <= $zoomConfig['wrapper_width']) {
                        $ratioModifierWidth = intval($zoomConfig['wrapper_width'] / ($zoomConfig['image_width'] * $zoomConfig['zoom_ratio']) );
                    }
                    if ($zoomConfig['image_height'] * $zoomConfig['zoom_ratio'] <= $zoomConfig['wrapper_height']) {
                        $ratioModifierHeight = intval($zoomConfig['wrapper_height'] / ($zoomConfig['image_height'] * $zoomConfig['zoom_ratio']) );
                    }
                    $zoomConfig['zoom_ratio'] = $zoomConfig['zoom_ratio'] + max($ratioModifierWidth,$ratioModifierHeight);
                    break;
                case 2:
                    /* full */
                    $zoomConfig['show_zoom_effect'] = "none";
                    $zoomConfig['hide_zoom_effect'] = "none";
                    $zoomConfig['wrapper_offset_left'] 	= 0;
                    $zoomConfig['wrapper_offset_top'] 	= 0;
                    $zoomConfig['wrapper_width'] 	= $zoomConfig['image_width'];
                    $zoomConfig['wrapper_height'] 	= $zoomConfig['image_height'];
                    break;
            }

            $zoomConfig['upscale_image_width'] = $zoomConfig['zoom_ratio'] * $zoomConfig['image_width'];
            $zoomConfig['upscale_image_height'] = $zoomConfig['zoom_ratio'] * $zoomConfig['image_height'];
            $bigImageWidth 	= $zoomConfig['upscale_image_width'];
            $bigImageHeight = $zoomConfig['upscale_image_height'];
            $mainImageWidth = $zoomConfig['image_width'];
            $mainImageHeight = $zoomConfig['image_height'];
            $thumbImageWidth = $zoomConfig['thumbnail_width'];
            $thumbImageHeight= $zoomConfig['thumbnail_height'];

        }else{
            /* smdzoom not being used */
            $bigImageWidth 	= null;
            $bigImageHeight = null;
            $mainImageWidth = null;//$this->getRequest()->getParam('img_width', null);
            $mainImageHeight= null;//$this->getRequest()->getParam('img_height', null);
            $thumbImageWidth = 76;
            $thumbImageHeight= 93;
        }

        $images = array();
        if (count($products) > 0) {
            foreach ($products as $simpleProduct) {
                if (count($images) == 0) {
                    $simpleProduct->load($simpleProduct->getId());
                    $simpleProductImages = $simpleProduct->getMediaGalleryImages();

                    if (count($simpleProductImages)) {
                        foreach ($simpleProductImages as $_image) {
                            if ($simpleProduct->getImage() == $_image->getData('file') ) { // Is base image if exsist go on top of array
                                array_unshift($images, array(
                                    'id'=> $_image->getId(),
                                    'product_id'=> $simpleProduct->getId(),
                                    'product'=> $simpleProduct,
                                    'label'=> $_image->getLabel(),
                                    'big_image'=> sprintf(Mage::helper('catalog/image')->init($simpleProduct, 'image', $_image->getFile())->resize($bigImageWidth, $bigImageHeight)),
                                    'image'=> sprintf(Mage::helper('catalog/image')->init($simpleProduct, 'image', $_image->getFile())->resize($mainImageWidth, $mainImageHeight)),
                                    'thumb'=> sprintf(Mage::helper('catalog/image')->init($simpleProduct, 'image', $_image->getFile())->resize($thumbImageWidth,$thumbImageHeight))
                                ));
                            } else {
                                array_push($images, array(
                                    'id'=> $_image->getId(),
                                    'product_id'=> $simpleProduct->getId(),
                                    'product'=> $simpleProduct,
                                    'label'=> $_image->getLabel(),
                                    'big_image'=> sprintf(Mage::helper('catalog/image')->init($simpleProduct, 'image', $_image->getFile())->resize($bigImageWidth, $bigImageHeight)),
                                    'image'=> sprintf(Mage::helper('catalog/image')->init($simpleProduct, 'image', $_image->getFile())->resize($mainImageWidth, $mainImageHeight)),
                                    'thumb'=> sprintf(Mage::helper('catalog/image')->init($simpleProduct, 'image', $_image->getFile())->resize($thumbImageWidth,$thumbImageHeight))
                                ));
                            }

                        }
                    }

                }
            }
        }

        if (count($images) == 0) {
            foreach ($_product->getMediaGalleryImages() as $_image) {
                $images[] = array(
                    'big_image'=> sprintf(Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->resize($bigImageWidth, $bigImageHeight)),
                    'image'=> sprintf(Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->resize($mainImageWidth, $mainImageHeight)),
                    'thumb'=> sprintf(Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->resize(76,93)),
                    'label'=> $_image->getLabel(),
                    'id'=> $_image->getId(),
                    'product_id'=> $productId,
                    'product'=> $_product
                );
            }
        }

        if (count($images) == 0) {
            echo "SMDesignColorswatchPreloader.removePerload($$('.product-image img')[0]);\n";
            if (Mage::getStoreConfig('smdesign_colorswatch/general/update_more_view')) {
                echo "$$('.more-views ul')[0].update('');";
            }
            $image = Mage::helper('catalog/image')->init($_product, 'image')->resize($mainImageWidth, $mainImageHeight);
            echo "$$('.product-image img')[0].src = '{$image}?rand=' + Math.random();";
            exit();
        }
        ?>


        data='';

        var MainImg = jQuery('<img id="zoom<?php echo $_product->getId()?>" class = "cloudzoom" src="<?php echo $images[0]['image']?>"   data-cloudzoom = "zoomImage: \'<?php echo $images[0]['image']?>\',zoomSizeMode: \'image\', autoInside : 991">');
        jQuery('.mediaimages .large-image').html(MainImg);
        <?php if (Mage::getStoreConfig('smdesign_colorswatch/general/update_more_view')) : ?>
            var galleryView = jQuery('.mediaimages .slides.thumbs');
            galleryView.html('');
            <?php foreach ($images as $key=>$image) : ?>
                var li =  jQuery('<li><img class="cloudzoom-gallery" src="<?php echo  $image['thumb'] ?>" alt="<?php echo  $image['label'] ?>" data-cloudzoom = "useZoom: \'#zoom<?php echo $_product->getId()?>\', image: \'<?php echo  $image['image'] ?>\', zoomImage: \'<?php echo  $image['image'] ?>\', autoInside : 991"/></li>');
                galleryView.append(li);
            <?php endforeach; ?>

            function flexdestroy(el, recreate=0, ver=0) {
            var elClean = el.clone();

            elClean.find('.flex-viewport').children().unwrap();
            elClean
            .removeClass('flexslider')
            .find('.clone, .flex-direction-nav, .flex-control-nav')
            .remove()
            .end()
            .find('*').removeAttr('style').removeClass (function (index, css) {
            return (css.match (/\bflex\S+/g) || []).join(' ');
            });

            elClean.insertBefore(el);
            el.remove();

            if(recreate)
            {
            if(ver)
            {
            elClean.flexVSlider({
            animation: "slide",
            direction: "vertical",
            move: 3,
            keyboard: false,
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            prevText: "",
            nextText: ""
            })
            }else{
            elClean.flexslider({
            animation: "slide",
            keyboard: false,
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            prevText: "",
            nextText: "",
            itemWidth: 76,
            itemMargin: 7
            })
            }

            }
            }

            slider=jQuery('.mediaimages .flexslider-thumb');
            sliderVer=jQuery('.mediaimages  .flexslider-thumb-vertical');
            sliderItemsNumber = slider.find(".slides.thumbs li").size();
            sliderVerItemsNumber = sliderVer.find(".slides.thumbs li").size();
            isInitiated = slider.find(".flex-direction-nav").size();
            isInitiatedVer = sliderVer.find(".flex-direction-nav").size();



            if(slider.length)
            {
            if (sliderItemsNumber > 3) {
            if(!isInitiated)
            {
            slider.flexslider({
            animation: "slide",
            keyboard: false,
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            prevText: "",
            nextText: "",
            itemWidth: 76,
            itemMargin: 7
            })
            } else {
            flexdestroy(slider,1);

            }
            } else {
            flexdestroy(slider);
            }
            }

            if(sliderVer.length)
            {
            if (sliderVerItemsNumber > 3) {
            if(!isInitiatedVer)
            {
            sliderVer.flexVSlider({
            animation: "slide",
            direction: "vertical",
            move: 3,
            keyboard: false,
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            prevText: "",
            nextText: ""
            })
            } else {
            flexdestroy(sliderVer,1,1);
            }
            } else {
            flexdestroy(sliderVer);
            }
            }


        <?php endif;?>
        CloudZoom.quickStart();

    <?php
    }
}
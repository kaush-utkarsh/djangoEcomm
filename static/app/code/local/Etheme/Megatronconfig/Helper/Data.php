<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alesioo
 * Date: 12.12.12
 * Time: 16:24
 * To change this template use File | Settings | File Templates.
 */
function loo_min ($s)
{
    return $s->price;
}

class Etheme_Megatronconfig_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function fileLoad($name, &$formData, $pathModule)
    {
        if (isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != null)
        {
            $fileUploader = new Varien_File_Uploader($name);
            $fileUploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $fileUploader->setAllowRenameFiles(false);
            $fileUploader->setFilesDispersion(false);
            //$path = Mage::getBaseDir() . DS.$pathModule.DS ;
            $path = 'skin' . DS . 'adminhtml' . DS . 'base' . DS . 'default' . DS . 'megatron' . DS . 'images' . DS . 'Configsets' . DS;
            $fileUploader->save($path, $_FILES[$name]['name']);
            $formData[$name] = $pathModule . DS . $_FILES[$name]['name'];
        }
    }

    //loop through folders and sub folders with option to remove specific files.
    public function listFolderFiles($dir, $exclude)
    {
        $ffs = scandir($dir);
        echo '<ul class="ulli">';
        foreach ($ffs as $ff) {
            if (is_array($exclude) and !in_array($ff, $exclude)
            ) {
                if ($ff != '.' && $ff != '..') {
                    if (!is_dir($dir . '/' . $ff)) {
                        echo '<li><a href="edit_page.php?path=' . ltrim($dir . '/' . $ff, './') . '">' . $ff . '</a>';
                    } else {
                        echo '<li>' . $ff;
                    }
                    if (is_dir($dir . '/' . $ff)) $this->listFolderFiles($dir . '/' . $ff, $exclude);
                    echo '</li>';
                }
            }
        }
        $listDir = array();
        echo '</ul>';
    }


    //Return an array of file names and folders in directory:
    function ReadFolderDirectory($dir = "root_dir/here")
    {
        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if (is_file($dir . "/" . $sub)) {
                        $listDir[] = $sub;
                    } elseif (is_dir($dir . "/" . $sub)) {
                        $listDir[$sub] = $this->ReadFolderDirectory($dir . "/" . $sub);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;
    }

    //view files by extension

    public function listFolderFiles_by_ext($dir, $type)
    {
        $dir = '.\\' . $dir . '\\'; // reminder: escape your slashes
        $filetype = "*." . $type;
        $filelist = shell_exec("dir {$dir}{$filetype} /a-d /b");
        $file_arr = explode("\n", $filelist);
        array_pop($file_arr); // last line is always blank
        return $file_arr;
    }


    public function cropResizeImg($fileName, $tmp, $width, $height = '')
    {
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;

        $basePath = $tmp;
        $newPath = Mage::getBaseDir() . DS . 'skin' . DS . 'adminhtml' . DS . 'base' . DS . 'default' . DS . 'megatron' . DS . 'images' . DS . 'Configsets' . DS . $fileName;

        if (is_file($tmp)) {
            $imageObj = new Varien_Image($basePath);
            $imageObj->constrainOnly(TRUE);
            $imageObj->keepAspectRatio(FALSE);
            $imageObj->keepFrame(FALSE);

            $currentRatio = $imageObj->getOriginalWidth() / $imageObj->getOriginalHeight();
            $targetRatio = $width / $height;

            if ($targetRatio > $currentRatio) {
                $imageObj->resize($width, null);
            } else {
                $imageObj->resize(null, $height);
            }

            $diffWidth = $imageObj->getOriginalWidth() - $width;
            $diffHeight = $imageObj->getOriginalHeight() - $height;


            //$imageObj->resize($width, $height);
            $imageObj->crop(
                floor($diffHeight * 0.5),
                floor($diffWidth / 2),
                ceil($diffWidth / 2),
                ceil($diffHeight * 0.5)
            );

            $imageObj->save($newPath);
        }

        return $fileName;
    }





    public function addToCartLink($_product, $el, $in_list_mode = false)
    {
        if(Mage::getStoreConfig('megatronconfig/options/show_add_to_cart'))        {

            if (Mage::getStoreConfig('megatronconfig/options/catalog_mode')) return;
            $output = '';
            if (!$in_list_mode) $output .= '';
            if ($_product->isSaleable()) {
                if (Mage::getStoreConfig('megatronconfig/options/ajax_add_to_cart')) {
                    if (!($_product->getTypeInstance(true)->hasRequiredOptions($_product) || $_product->isGrouped())) {
                        if (!$in_list_mode) $output .= '<li><a class="cart"  onclick="setLocationAjax(\'' . $el->getAddToCartUrl($_product) . '\',\'' . $_product->getId() . '\')"><span class="icon-basket"></span></a></li>';
                        else $output .= '<a class="btn btn-mega pull-left"  onclick="setLocationAjax(\'' . $el->getAddToCartUrl($_product) . '\',\'' . $_product->getId() . '\')">'.$el->__('Add to Cart').'</a>';

                    } else {
                        if (!$in_list_mode) $output .= '<li><a class="cart" href="' . $el->getAddToCartUrl($_product) . '"><span class="icon-basket"></span></a></li>';
                        else $output .= '<a class="btn btn-mega pull-left" href="' . $el->getAddToCartUrl($_product) . '">'.$el->__('Add to Cart').'</a>';
                   }
                } else {
                    if (!$in_list_mode) $output .= '<li><a class="cart" href="' . $el->getAddToCartUrl($_product) . '"><span class="icon-basket"></span></a></li>';
                    else $output .= '<a class="btn btn-mega pull-left" href="' . $el->getAddToCartUrl($_product) . '">'.$el->__('Add to Cart').'</a>';
                }
            } else {
                 $output .= '<li><a class="outofstock">' . $el->__('Out of stock') . '</a></li>';
            }
            if (!$in_list_mode) $output .= '';
            return $output;
        } else return;
    }




    public function addWishCompLink($_product, $el,$in_list_mode=false)
    {
        $output = '';



        if(Mage::getStoreConfig('megatronconfig/options/catalog_mode'))return;

            if (Mage::getStoreConfig('megatronconfig/options/ajax_wish_comp'))
            {
                if (Mage::helper('wishlist')->isAllow() && Mage::getStoreConfig('megatronconfig/options/show_add_to_wishlist'))
                {
                    if(!$in_list_mode)$output .= '<li><a class="circle" href="#"  onclick="ajaxWishlist(\'' . $el->helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)) . '\',' . $_product->getId() . ');return false;"><span class="icon-heart"></span></a></li>';
                    else
                        $output .= '<li> <a href="#" onclick="ajaxWishlist(\'' . $el->helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)) . '\',' . $_product->getId() . ');return false;"><i class="icon-heart"></i></a> <a href="#" onclick="ajaxWishlist(\'' . $el->helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)) . '\',' . $_product->getId() . ');return false;">'.$el->__('Add to Wish List').'</a> </li>';

                }

                if(Mage::getStoreConfig('megatronconfig/options/show_add_to_compare'))
                {
                    if ($_compareUrl = $el->getAddToCompareUrl($_product)) {

                        if(!$in_list_mode)$output .= '<li><a class="circle" href="#" onclick="ajaxCompare(\'' . $_compareUrl . '\',' . $_product->getId() . ');return false;"><span class="icon-justice"></span></a></li>';
                        else $output .= '<li> <a href="#" onclick="ajaxCompare(\'' . $_compareUrl . '\',' . $_product->getId() . ');return false;"><i class="icon-justice"></i></a> <a href="#" onclick="ajaxCompare(\'' . $_compareUrl . '\',' . $_product->getId() . ');return false;">'.$this->__('Add to Compare').'</a> </li>';

                    }
                }

            }else{

                    if (Mage::helper('wishlist')->isAllow() && Mage::getStoreConfig('megatronconfig/options/show_add_to_wishlist'))
                    {
                        if(!$in_list_mode)$output .= '<li><a class="circle" href="'.Mage::helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)).'"><span class="icon-heart"></span></a></li>';
                        else
                        $output.='<li> <a href="'.Mage::helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)).'"><i class="icon-heart"></i></a> <a href="'.Mage::helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)).'">'.$el->__('Add to Wish List').'</a> </li>';
                    }
                    if(Mage::getStoreConfig('megatronconfig/options/show_add_to_compare'))
                    {
                        if(!$in_list_mode)$output .= '<li><a class="circle" href="'.Mage::helper('catalog/product_compare')->getAddUrl($_product) . '"><span class="icon-justice"></span></a></li>';
                        else $output .= '<li> <a href="'.Mage::helper('catalog/product_compare')->getAddUrl($_product) . '"><i class="icon-justice"></i></a> <a href="'.Mage::helper('catalog/product_compare')->getAddUrl($_product) . '">'.$this->__('Add to Compare').'</a> </li>';
                    }
            }
        return $output;
    }

    public function drawProductPreview($_product, $el, $widthBig, $heightBig, $price, $in_listing=false, $class='',$in_slider=false,$izotope=false,$category_id=0,$list_mode='grid',$related_to_right=false)
    {
        $html=array();
        if(Mage::getStoreConfig('megatronconfig/options/catalog_mode'))$price='';

        /*CHECK IZOTOP MODE AND 2x Products*/
        $class2x='';
        $izotope_mode=Mage::getStoreConfig('megatronlayout/options/izotop_mode');
        if($izotope_mode && $in_listing && $list_mode=='grid')
        {
            $category_double_product_ids=explode(',',Mage::getStoreConfig('megatronlayout/options/products_2x'));

            if( in_array($_product->getId(),$category_double_product_ids))
            {
                $class2x='width-two-column';
                $widthBig*=2;
                $heightBig*=2;
            }
        }
        /*end check izotop*/

        /*ROLLOVER IMAGE*/
        $rollover=false;
        if(Mage::getStoreConfig('megatronconfig/options/image_rollover_mode'))
        {
            $_product->load('media_gallery');
            if ($temp = $_product->getMediaGalleryImages())
            {
                if ($_image = $temp->getItemByColumnValue('position', Mage::getStoreConfig('megatronconfig/options/image_rollover_sort')))
                {
                    $rollover_image='<img src="'.$el->helper('catalog/image')->init($_product, 'small_image',$_image->getFile())->resize($widthBig, $heightBig) . '" class="img-responsive  animate scale product-retina" data-image2x="' . $el->helper('catalog/image')->init($_product, 'small_image',$_image->getFile())->resize($widthBig * 2, $heightBig * 2) . '"    alt="' . $el->stripTags($_product->getName(), null, true) . '">';
                    $rollover=true;
                }
            }
        }
        /*ROLLOVER IMAGE END*/



        //$image_src=$el->helper('catalog/image')->init($_product, 'small_image')->resize($widthBig, $heightBig);
        $image_src=$el->helper('catalog/image')->init($_product, 'small_image')->resize($widthBig, $heightBig);

        if($izotope)
        {
            $category_id='category_id_'.$category_id;
            if($category_id=='category_id_new')$category_id='new';
        }
        if(!$izotope && !$in_listing)
        {
            $html[]='<div class="item">';
            $category_id='';
        }

        $html[]='<div class="product-preview '.$category_id.' '.$class2x.'">';

            /*-preview-*/
            $html[]='<div class="preview animate scale '.($rollover?'hover-slide':'').'">';
                $html[]='<a href="'.$_product->getProductUrl().'" class="preview-image" '.(($rollover && $izotope_mode && $in_listing)?'style="height:'.$heightBig.'px"':'').'>';
                    if($rollover)$html[]=$rollover_image;
                    $html[]='<img  src="'.$image_src.'" class="product-retina img-responsive"   data-image2x="' . $el->helper('catalog/image')->init($_product, 'small_image')->resize($widthBig * 2, $heightBig * 2) . '"  alt="' . $el->stripTags($_product->getName(), null, true) . '">';

                $html[]='</a>';
                $html[]=$this->getProductLabel($_product,$el);
                if($list_mode=='list')
                {
                    $html[]=$this->countdownSpecialPrice($_product,'defaultCountdown',$el,true);
                }else
                {
                    $html[]=$this->countdownSpecialPrice($_product,'defaultCountdown',$el);
                }

                /*buttons*/
                $html[]='<ul class="product-controls-list right hide-right">';
                    if($in_listing && Mage::getStoreConfig('megatronlayout/options/products_size')=='small')
                    {
                        $html[]='<li class="top-out-small"></li>';
                    }
                    else
                    {
                        $html[]='<li class="top-out"></li>';
                    }

                    $html[]=$this->addWishCompLink($_product, $el);
                    $html[]=$this->addToCartLink($_product, $el);
                $html[]='</ul>';
                /*buttons end*/

               /*quick view*/
               $quick_view=Mage::getStoreConfig('megatronconfig/options/quick_view');
               $quick_view_style=Mage::getStoreConfig('megatronconfig/options/quick_view_style');
               if($quick_view || Mage::getStoreConfig('megatronconfig/options/show_rating'))
               {
                   if($this->getStars($_product) || $this->QuickView($_product,$el))
                   {

                       if($quick_view && $quick_view_style=='in' && !($in_listing && $izotope_mode) && !($related_to_right) && !$izotope)
                       {
                           $html[]='<a href="'.$el->getUrl('ajax/index/options', array('product_id' => $_product->getId(), '_secure' => Mage::app()->getFrontController()->getRequest()->isSecure())).'"  class="quick-view hidden-xs">';
                       }elseif(($quick_view && $quick_view_style=='out') || ($in_listing && $izotope_mode) || $related_to_right || $izotope)
                       {
                           $html[]='<a href="'.$el->getUrl('ajax/index/popup', array('product_id' => $_product->getId(), '_secure' => Mage::app()->getFrontController()->getRequest()->isSecure())).'"  class="quick-view hidden-xs fancybox fancybox.ajax">';
                       }else
                       {
                           $html[]='<a   class="quick-view hidden-xs">';
                       }

                       if($this->getStars($_product) && Mage::getStoreConfig('megatronconfig/options/show_rating'))
                       {
                           $html[]='<span class="rating">'.$this->getStars($_product).'</span>';
                       }
                       $html[]=$this->QuickView($_product,$el);
                       $html[]='</a>';
                   }

               }
               /*quick end*/


            $html[]='</div>';
            /*-preview end-*/


            $html[]='<h3 class="title"><a href="'.$_product->getProductUrl().'" title="'.$el->stripTags($_product->getName(), null, true).'">' . $el->stripTags($_product->getName(), null, true) . '</a></h3>';

            /*COLOR SWATCH EXTENTION*/
            if(Mage::helper('core')->isModuleEnabled('SMDesign_ColorswatchProductList')){
                $listHelper = Mage::helper('colorswatchproductlist');
                if ( $_product->getData('smd_colorswatch_product_list') && Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE == $_product->getTypeId() ){
                    $_colorswatch='';
                    $html[]=$listHelper->showSwatches($_product,$_colorswatch);
                }
            }
            /*END COLOR SWATCH EXTENTION*/





            $html[]=$price;

            /*AMASTY COLOR SWATCH EXTENTION*/
            if(Mage::helper('core')->isModuleEnabled('Amasty_Conf')){

                    $html[]='<div class="actions"><button type="button" title=""></button></div>';

            }
            /*END AMASRY COLOR SWATCH EXTENTION*/


        /*IN LISTING -  LIST MODE */
            if($list_mode=='list')
            {
                $html[]='<div class="list_rating"><span class="rating">'.$this->getStars($_product).'</span></div>';
                $html[]='<div class="list_description">'.Mage::helper('catalog/output')->productAttribute($_product, $_product->getShortDescription(), 'short_description').'</div>';
                $html[]='<div class="list_buttons">';
                    $html[]=$this->addToCartLink($_product, $el,true);
                    $html[]='<div class="add-to-links"><ul>';
                    $html[]=$this->addWishCompLink($_product, $el,true);
                $html[]='</ul></div></div>';
            }
            /*END LIST MODE */

        $html[]='</div>';
        if(!$izotope && !$in_listing)$html[]='</div>';



        $html = implode("\n", $html);
        return $html;
    }



    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    function getProductLabel($_product,$el)
    {


        $html = array();


            $now = date("Y-m-d");
            $specialFrom = substr($_product->getData('special_from_date'), 0, 10);
            $specialTo = substr($_product->getData('special_to_date'), 0, 10);

            $special = false;

            if (!empty($specialFrom) && !empty($specialTo)) {
                if ($now >= $specialFrom && $now <= $specialTo) $special = true;

            } elseif (!empty($specialFrom) && empty($specialTo)) {
                if ($now >= $specialFrom) $special = true;

            } elseif (empty($specialFrom) && !empty($specialTo)) {
                if ($now <= $specialTo) $special = true;
            }
            if ($special) $html[] = '<ul class="product-controls-list right">';
            if (Mage::getStoreConfig('megatronconfig/product_labels/show_sale_label')) {
                if ($special) $html[] = '<li><span class="label label-sale">'.$el->__('Sale').'</span></li>';
            }
            $html[] = $this->outputDiscountLabel($_product);
            if ($special) $html[] = '</ul>';



        if (Mage::getStoreConfig('megatronconfig/product_labels/show_new_label')) {
            $now = date("Y-m-d");
            $newsFrom = substr($_product->getData('news_from_date'), 0, 10);
            $newsTo = substr($_product->getData('news_to_date'), 0, 10);

            $new = false;

            if (!empty($newsFrom) && !empty($newsTo)) {
                if ($now >= $newsFrom && $now <= $newsTo) $new = true;

            } elseif (!empty($newsFrom) && empty($newsTo)) {
                if ($now >= $newsFrom) $new = true;

            } elseif (empty($newsFrom) && !empty($newsTo)) {
                if ($now <= $newsTo) $new = true;
            }

            if ($new) $html[] ='<ul class="product-controls-list">
                  <li><span class="label label-new">'.$el->__('New').'</span></li>
                </ul>';

        }

        $html = implode("\n", $html);
        return $html;
    }



    public function outputDiscountLabel($_product)
    {

        if(Mage::getStoreConfig('megatronconfig/options/catalog_mode'))return;
        if (!($_product->type_id == 'grouped' || $_product->type_id == 'bundle')) {

            if(!Mage::getStoreConfig('megatronconfig/product_labels/discount_label'))return;
            if ($_product->type_id != 'grouped')
                $price_new = $_product->getFinalPrice();
            else
                $price_new = $_product->min_price;

            $price_old = $_product->getPrice();

            if($price_old==0)$price_old=1;
            $discount=round((($price_new-$price_old)*100)/$price_old);

            if($discount!=0)
            return '<li><span class="label">'.$discount.'%</span></li>';
            else return '';
        } else return '';


    }

    public function QuickView($_product,$el)
    {
        if(!Mage::getStoreConfig('megatronconfig/options/quick_view'))return;
        return '
             <span class="icon-zoom-in-2 cursor-hand" onclick="showOptions(\'' . $_product->getId() . '\')"></span> '.$el->__('Quick View').'
        ';
    }

    public function QuickViewShort($_product,$el)
    {
        if(!Mage::getStoreConfig('megatronconfig/options/quick_view'))return;
        return '
             <span class="icon-zoom-in-2 cursor-hand" onclick="showOptions(\'' . $_product->getId() . '\')"></span> '.$el->__('View').'
        ';
    }



    function replace_uri($str) {
        $pattern = '#(^|[^\"=]{1})(http://|ftp://|mailto:|news:)([^\s<>]+)([\s\n<>]|$)#sm';
        return preg_replace($pattern,"\\1<a target=\"_blank\" href=\"\\2\\3\">\\2\\3</a>\\4",$str);
    }


    function refreshCssFiles($store, $website)
    {
        /*3 ways to refresh CSS
         * DEFAULT-WEBSITES-STORES  (All available stores)
         * WEBSITES-STORES (stores from choosen website)
         * STORE (choosen store)
         * */
        if(!$website)
        {
            //refresh all Websites css
            foreach(Mage::app()->getWebsites() as $website)
            {
                $this->refreshWebsiteStores($website);
            }
        }
        else
        {
            if($store)
            {
                //refresh Store css
                $this->refreshStoreCss($store);
            }
            else
            {
                //refresh Website css
                $this->refreshWebsiteStores($website);
            }
        }
    }

    function refreshStoreCss($store)
    {
        Mage::register('store_for_css', $store);
        $path = Mage::getBaseDir() . '/' . 'skin/frontend/megatron/default/css/colors/';

        $prefix = 'colors_';
        if ($store) {
            $filename = $store;
        }

        $path_full = $path . $prefix . $filename . '.css';


        /*
         * how get frontend phtml output http://stackoverflow.com/questions/12290938/get-frontend-phtml-templates-output-inside-a-model-method-in-magento
         * */
        $css_output = Mage::app()->getLayout()->createBlock('core/template')->setData('area', 'frontend')->setTemplate('etheme/megatron/cssrefresh/colors.phtml')->toHtml();

        /*
         * write to file described here  http://inchoo.net/ecommerce/magento/magento-code-library/
         * */
        try {
            if(file_exists($path_full))unlink($path_full);
            $flocal = new Varien_Io_File();
            $flocal->open(array('path' => $path));
            $flocal->streamOpen($path_full, 'w+');
            $flocal->streamWrite($css_output);
            $flocal->streamClose();
            Mage::getSingleton('adminhtml/session')->addSuccess('CSS file '.$prefix.$store.'.css was refreshed successfully.');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        Mage::unregister('store_for_css');
    }

    function refreshWebsiteStores($website)
    {
        foreach(Mage::app()->getWebsite($website)->getStoreCodes() as $store)$this->refreshStoreCss($store);
    }

    public function getIsHomePage()
    {
        $page = Mage::app()->getFrontController()->getRequest()->getRouteName();
        $homePage = false;

        if($page =='cms'){
            $cmsSingletonIdentifier = Mage::getSingleton('cms/page')->getIdentifier();
            $homeIdentifier = Mage::app()->getStore()->getConfig('web/default/cms_home_page');
            if($cmsSingletonIdentifier === $homeIdentifier){
                $homePage = true;
            }
        }

        return $homePage;
    }

    function countdownSpecialPrice($_product,$selector,$el,$in_list_mode=false)
    {
        $output='';
        $specialTo = substr($_product->getData('special_to_date'), 0, 10);
        $now = date("Y-m-d");
        if (!empty($specialTo) && Mage::getStoreConfig('megatronconfig/options/countdown')) {
            if ($now < $specialTo)
            {
                $to_year=substr($_product->getData('special_to_date'), 0, 4);
                $to_month=substr($_product->getData('special_to_date'), 5, 2);
                $to_day=substr($_product->getData('special_to_date'), 8, 2);


                $output.=' <div class="countdown_box">
                    <div class="countdown_inner">
                        <div class="title">'.$el->__('This limited  offer ends in').'</div>
                        <div class="'.$selector.'-'.$_product->getId().' hasCountdown"></div>
                      </div>
                    </div>
                    <script type="text/javascript">
                    jQuery(function () {
                        jQuery(".'.$selector.'-'.$_product->getId().'").countdown({'.((Mage::getStoreConfig('megatronlayout/options/products_size')=='small' || $in_list_mode)?'compact:true,':'').'until: new Date('.$to_year.','.($to_month-1).', '.$to_day.')});
                    });
                   </script>';


            }
        }
        return $output;
    }

    public function getStars($_product)
    {
        if(!Mage::getStoreConfig('megatronconfig/options/show_rating')) return;
        /**
         * Getting reviews collection object
         */
        $productId = $_product->getId();
        $reviews = Mage::getModel('review/review')
            ->getResourceCollection()
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addEntityFilter('product', $productId)
            ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
            ->setDateOrder()
            ->addRateVotes();
        /**
         * Getting average of ratings/reviews
         */
        $stars = 0;
        $avg = 0;
        $output = '';
        $ratings = array();
        if (count($reviews) > 0) {
            foreach ($reviews->getItems() as $review) {
                foreach ($review->getRatingVotes() as $vote) {
                    $ratings[] = $vote->getPercent();
                }
            }
            $crat=count($ratings);
            if($crat==0)$crat=1;
            $avg = array_sum($ratings) / $crat;
            $stars = round($avg * 5 / 100);
        }

        if ($stars) {
            for ($i = 0; $i < $stars; $i++) $output .= '<i class="icon-star-3"></i> ';
            for ($i = 0; $i < (5 - $stars); $i++) $output .= '<i class="icon-star-empty"></i> ';
        }

        return $output;
    }



}
<?php
class Etheme_Megatronconfig_Block_Megamenu extends Mage_Catalog_Block_Navigation
{

    /**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false,
                                                   $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false,$grid_row=12,
                                                   $grid_col=2)
    {
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();

        $black_list=Mage::getStoreConfig('megatronconfig/megamenu/black_list');
        $black_list=explode(',',$black_list);
        if(in_array($category->getId(),$black_list))return;

        $type_a=true;
        if(Mage::getStoreConfig('megatronconfig/megamenu/megamenu_type')!='type_a')$type_a=false;
        // get all children
        // If Flat Data enabled then use it but only on frontend
        $flatHelper = Mage::helper('catalog/category_flat');
        if (Mage::helper('catalog/category_flat')->isEnabled()) {
            $children = (array)$category->getChildrenNodes();
            $childrenCount = count($children);
        } else {
            $children = $category->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = ($children && $childrenCount);

        // select active children
        $activeChildren = array();
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }
        }
        $activeChildrenCount = count($activeChildren);
        $hasActiveChildren = ($activeChildrenCount > 0);

        // prepare list item html classes
        $classes = array();

        if($level==0)
        {
            $classes[]='item';
            //$classes[]='compact-hidden';
        }
        if($level==0 && $hasChildren){
            $classes[]='with-sub';
        }


        $classes[] = 'level' . $level;
        $classes[] = 'nav-' . $this->_getItemPosition($level);
        if ($this->isCategoryActive($category)) {
            if($level!=0) $classes[] = 'active'; else $classes[] = 'current';
        }
        $linkClass = '';
        if ($isOutermost && $outermostItemClass) {
            $classes[] = $outermostItemClass;
            $linkClass = ' class="'.$outermostItemClass.'"';
        }
        if ($isFirst) {
            $classes[] = 'first';
        }
        if ($isLast) {
            $classes[] = 'last';
        }
        if ($hasActiveChildren) {
            $classes[] = 'parent';
        }

        if($level==0 or $level==1) {
            $category_data=Mage::getModel('catalog/category')->load($category->getId());
            $label= $category_data->getBs_category_lable();
        }

        if($level==1)
        {
            $smallDesc=$category_data->getBs_small_cat_desc();
            $smallDesc = Mage::helper('cms')->getBlockTemplateProcessor()->filter($this->helper('catalog/output')->categoryAttribute($category, $smallDesc, 'bs_small_cat_desc'));
            $category_thumb=$category_data->getThumbnail();
        }

        if($level==0)
        {
            $descriptionTop=$category_data->getBs_top_html();
            $descriptionTop = Mage::helper('cms')->getBlockTemplateProcessor()->filter($this->helper('catalog/output')->categoryAttribute($category, $descriptionTop, 'bs_top_html'));
            $descriptionBtm = $category_data->getBs_btm_html();
            $descriptionBtm = Mage::helper('cms')->getBlockTemplateProcessor()->filter($this->helper('catalog/output')->categoryAttribute($category, $descriptionBtm, 'bs_btm_html'));
            $description = Mage::getModel('catalog/category')->load($category->getId())->getMenutopdescription1();
            $description = Mage::helper('cms')->getBlockTemplateProcessor()->filter($this->helper('catalog/output')->categoryAttribute($category, $description, 'menutopdescription1'));
            $cols = $category_data->getBs_count_columns();
            $cols_real=$category_data->getBs_count_columns();
            if(empty($cols))$cols=6;
            if($cols>6)$cols=6;
            if($cols<1)$cols=1;

            $grid_row=12;

            if(!empty($description))$grid_row=9;
            if(!empty($description) && $cols==6)$cols=4;
            if(!$type_a && !empty($description) && !$cols_real)$cols=6;

            switch($cols)
            {
                case 6:
                    $grid_col=2;
                    break;
                case 4:
                    $grid_col=3;
                    break;
                case 3:
                    $grid_col=4;
                    break;
                case 2:
                    $grid_col=6;
                    break;
                default:
                    $grid_col=2;
                    if(!empty($description))$grid_col=3;
                    break;
            }
        }

        
        // assemble list item with attributes
        switch($level)
        {
            case 0:
                $htmlLi = '<dt';
                break;
            case 1:
                $classes[]='submenu-block';
                if(!$type_a)$classes[]='submenu-block-other';
                $htmlLi = '<div class="col-xs-6 col-md-4 col-lg-'.$grid_col.'">
                                    <div
                              ';
                break;
            default:
                $htmlLi = '<li';
                break;

        }

        // prepare list item attributes
        $attributes = array();
        if (count($classes) > 0) {
            $attributes['class'] = implode(' ', $classes);
        }
        if ($hasActiveChildren && !$noEventAttributes) {
            $attributes['onmouseover'] = 'toggleMenu(this,1)';
            $attributes['onmouseout'] = 'toggleMenu(this,0)';
        }



        foreach ($attributes as $attrName => $attrValue) {
            $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
        }
        $htmlLi .= '>';


        $html[] = $htmlLi;

        switch($level){
            case 0:
                if($hasChildren)$html[] = '<a href="#"'.$linkClass.' class="btn-main line">';
                else
                $html[] = '<a  class="btn-main line" href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>'; 
                break;
            case 1:
                if($type_a){
                    $category_icon=$category_data->getBs_category_icon();
                    $category_icon=$category_icon?$category_icon:'empty';
                    $html[] = '<span class="icon '.$category_icon.'">'.(($category_icon=='empty')?'&nbsp;':'').'</span>';
                }else
                {
                    if(!empty($category_thumb) && Mage::getStoreConfig('megatronconfig/megamenu/show_thumbs')){
                        $html[] = '<a class="thumb" href="'.$this->getCategoryUrl($category).'"><img src="'.Mage::getBaseUrl('media').'catalog/category/'.$category_thumb.'" class="img-responsive" border="0" alt="'.$this->escapeHtml($category->getName()).'" /></a>';
                    }
                    $html[] = '<div class="title">';
                }
                $html[] = '<a href="'.$this->getCategoryUrl($category).'"'.$linkClass.' class="name">';
                break;

            default:
                $html[] = '<a href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>';
                break;
        }

        $html[] = $this->escapeHtml($category->getName());
        $html[] = '</a>';

        if($level==1)
        {
            $label= $category_data->getBs_category_lable();
            if(!empty($label))$html[]='<span class="label label-mega">'.$label.'</span>';
        }

        if(!$type_a && $level==1)
        {
           $html[] = '</div>';
        }

        if($level==0)$htmlLi = '</dt>'; //else $htmlLi = '</li>';

        if($level==0 && $hasChildren)
        {
            $html[]='<dd class="item-content">
                <div class="navbar-main-submenu"> <a href="#" class="button-up"><span class="icon-arrow-up-3"></span> </a>';

            /*Show Toplevel Link*/
            $html[] = '<ul class="exclusive toplevelcategory">
                    <li><span class="icon icon-coins"></span><a href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>';
            $html[] =$this->__('View All').' ';
            $html[] =$this->escapeHtml($category->getName());
            $html[] = '</a></li>
                  </ul>';
            /*---*/

            if(!empty($descriptionTop))  $html[]= $descriptionTop;

            $html[]='<div class="wrapper-border">
                    <div class="row">';

            if($type_a)$html[]='
            <!-- caregories -->
            <div class="col-xs-'.$grid_row.'">
                        <div class="row">
                  ';
        }

        // render children
        $htmlChildren = '';
        $j = 0;
        foreach ($activeChildren as $child) {
            $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                $child,
                ($level + 1),
                ($j == $activeChildrenCount - 1),
                ($j == 0),
                false,
                $outermostItemClass,
                $childrenWrapClass,
                $noEventAttributes,
                $grid_row,
                $grid_col
            );
            $j++;
        }


        if (!empty($htmlChildren)) {

            if($level!=0)$html[] = '<ul class="level' . $level . '">';
            $html[] = $htmlChildren;
            if($level!=0)$html[] = '</ul>';
        }

        if($level==1 && !$type_a)
        {
            if(!empty($smallDesc) && Mage::getStoreConfig('megatronconfig/megamenu/show_desc'))
            {
                $html[]='<p>'.html_entity_decode($smallDesc).'</p>';
            }
        }
        if($level==1)
        {
            $html[]=' </div>
                          </div>';
        }

        if($level==0 && $hasChildren && $type_a)
        {
            $html[]='
                        </div>
                      </div>
                      <!-- //end caregories -->

                      <!-- html block -->
                      ';

            if(!empty($description)) {
                $html[]='<div class="col-xs-3">';
                $html[]=html_entity_decode($description);
                $html[]='</div>';
            }
            $html[]='<!-- //end html block -->


                    </div>
                  </div>';

            if(!empty($descriptionBtm))  $html[]= $descriptionBtm;

            $html[]=' </div>
                    </dd>';
        }

        $html = implode("\n", $html);
        return $html;
    }
}
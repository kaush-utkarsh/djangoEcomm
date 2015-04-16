<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howmanwordpress extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_update\'); return false;" href="#" id="how_manwordpress-head">How manage wordpress</a></div>
<input id="how_manwordpress-state" type="hidden" value="1" name="config_state[how_manwordpress]">
<fieldset id="how_manwordpress" class="config collapseable">


1.Install extention http://www.magentocommerce.com/magento-connect/magento-wordpress-integration.html (get code and paste it in admin/system/magento connect/magento connect manager)<br />
2.Download Wordpress cms from https://wordpress.org/download/<br />
3.Install Wordpress in corner of your site in folder wp/<br />
4.In installed wordpress goto admin panel / Settings / Media / set \'Thumbnail size\' width 176 and height 119, enable Crop<br />
5.In Magento Admin / Wordpress / Settings / Database - configure your  access<br />
6.In Magento Admin / Wordpress / Settings / Template - set \'Default\' - 2 columns with right bar<br />

7.In Wordpress add new posts<br /><br />

How see link to blog in megamenu?<br />

Goto Cms/Static block mtron_topmenu_megamenu_left and add there href {{store url=\'blog\'}}
<br /><br />
Flush Cache!

</fieldset></div>';
    }
}

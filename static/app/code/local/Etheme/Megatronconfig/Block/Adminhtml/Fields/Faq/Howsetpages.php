<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howsetpages extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_update\'); return false;" href="#" id="how_setpages-head">How Create Pages</a></div>
<input id="how_setpages-state" type="hidden" value="1" name="config_state[how_setpages]">
<fieldset id="how_setpages" class="config collapseable">

<b>If you want create pages:</b><br />
&nbsp;&nbsp;&nbsp;&nbsp;1. About Us<br />
&nbsp;&nbsp;&nbsp;&nbsp;2. Delivery<br />
&nbsp;&nbsp;&nbsp;&nbsp;3. Faq<br />
&nbsp;&nbsp;&nbsp;&nbsp;4. Infographic<br />
&nbsp;&nbsp;&nbsp;&nbsp;5. Our Office<br />
&nbsp;&nbsp;&nbsp;&nbsp;6. Our Services<br />
&nbsp;&nbsp;&nbsp;&nbsp;7. Our Store<br />
&nbsp;&nbsp;&nbsp;&nbsp;8. Pages<br />
&nbsp;&nbsp;&nbsp;&nbsp;9. Pricing Tables<br />
&nbsp;&nbsp;&nbsp;&nbsp;10. Team Members<br />
&nbsp;&nbsp;&nbsp;&nbsp;11. Video Section<br /><br />

You need create cms page and paste in content area data from one of the files in folder \'Pages Data\' in Megatron Template Package.




</fieldset></div>';
    }
}

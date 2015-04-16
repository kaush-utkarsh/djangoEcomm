<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Home extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
      
        return '
<div class="section-config">

<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'megamenu\'); return false;" href="#" id="content-head">Home Page</a>
</div>

<input id="content-state" type="hidden" value="1" name="config_state[content]">
<fieldset id="content" class="config collapseable"  >
Home page you can manage here - Cms  > Pages > megatron_home

<ul>
	<li>
		<code>



<hr />
<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'etheme/megatron/adminhtml/content_1.png" />





</code>
	</li>
</ul>





</fieldset>
</div>
';
    }
}

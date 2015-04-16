<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Footer extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
      
        return '
<div class="section-config">

<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'megamenu\'); return false;" href="#" id="footer-head">Footer</a>
</div>

<input id="footer-state" type="hidden" value="1" name="config_state[footer]">
<fieldset id="footer" class="config collapseable"  >


<ul>
	<li>
		<code>



<hr /><br />
<b>Q: How edit footer data?</b><br/>
A:See on screenshot
<br />
<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'etheme/megatron/adminhtml/footer_1.png" />

footer file location \app\design\frontend\megatron\default\template\page\html\footer.phtml




</code>
	</li>
</ul>





</fieldset>
</div>
';
    }
}

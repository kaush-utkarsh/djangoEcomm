<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howmangallery extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_update\'); return false;" href="#" id="how_mangallery-head">How manage gallery</a></div>
<input id="how_mangallery-state" type="hidden" value="1" name="config_state[how_mangallery]">
<fieldset id="how_mangallery" class="config collapseable">


Create CMS/Page named for ex. Gallery with URL Key  \'gallery\'<br />
Paste in content area next shortcode:<br /><br />

<pre><b>
&lt;section class="container"&gt;
{{block type="megatrongallery/megatrongallery"   block_name="Gallery Title"  template="gallery/grid.phtml"}}
&lt;/section&gt;</b>
</pre>
<br />
Add gallery items you can In Megatron Tab - Gallery <br />

If you use megamenu you can add link  to gallery in cms/block mtron_topmenu_megamenu_left/right &lt;a href="<b>{{store direct_url=\'gallery\'}}</b> "&gt;Gallery&lt;/a&gt;

</fieldset></div>';
    }
}

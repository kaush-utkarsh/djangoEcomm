<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howupdate extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_update\'); return false;" href="#" id="how_update-head">How modify & update theme</a></div>
<input id="how_update-state" type="hidden" value="1" name="config_state[how_update]">
<fieldset id="how_update" class="config collapseable">


IF you want to do some template changes you need create subtheme in megatron design package.<br />
Default directory structure this<br /><br />
app<br />
&nbsp;+ design<br />
&nbsp;&nbsp;&nbsp;&nbsp;+ frontend<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ megatron  (package)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ default  (theme in package)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ layout<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ template<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <b>mysubtheme</b>	(this theme you need create)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- layout (if you have your own behavior of layout)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- template	(if you have to rewrite template files) <br /><br />
Do not forget that you need write in System/Configuration/Design  theme - <b>mysubtheme</b><br /><br />

For ex. you want modify view of some element on fronted. <br /><br />
<b>How to turn on \'Template Path Hints\'</b><br />
When viewing your theme, it\'s helpful to see which template file is being used for which part of the page. Magento has an excellent debugging tool called \'Template Path Hints\'.<br />

1. Admin / System / Configuration.<br />

2. Select your store from the drop-down in the upper-left corner and wait for the page to reload. Note that you have to be on the website level or lower. The \'Template Path Hints\' option will not be visible if you are at a higher level.<br />

3. Advanced / Developer (all the way at the bottom).<br />

4. Template Path Hints / Yes.<br />

5. Hit the orange Save Config button.<br /><br />

Go to your store and reload.<br />

You will see path to template file. Copy this file from megatron/default/template to megatron/subtheme/template, or from base/default/template to  megatron/subtheme/template<br /><br />


<b>How to turn off Magento\'s cache</b><br />
When developing a theme/package, it\'s helpful to not have to wait for your changes to expire the built-in cache. Here\'s how to disable Magento\'s cache so that you can see your changes right away:<br />

1. Admin / System / Cache Management<br />

2. In the Cache Control section, for the All Cache drop-down, select Disable.<br />

3. Click the orange Save Cache Settings button.<br /><br />

Css changes you need write in file DELETE-PREFIXcustom_changes.css  (here you need delete prefix and in megatron color setting set use custom css file enabled)<br /><br />
Core files you need change only with extend tools (magento allows rewrite classes, helpers, models by extend methods)<br /><br />

IF you will follow these steps you will not have problems with update theme. <br />
Update theme you can with simple reuploading of megatron files.<br />



</fieldset></div>';
    }
}

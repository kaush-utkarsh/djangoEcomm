<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howsetthemes extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_update\'); return false;" href="#" id="how_setthemes-head">How Enable Subthemes - Food, Kids, Electronics</a></div>
<input id="how_setthemes-state" type="hidden" value="1" name="config_state[how_setthemes]">
<fieldset id="how_setthemes" class="config collapseable">

<b>How Enable Food subtheme:</b><br />

&nbsp;&nbsp;&nbsp;&nbsp;1. Goto System/Configuration/Design/Themes/Default write \'food\'.<br />
&nbsp;&nbsp;&nbsp;&nbsp;2. Goto System/Configuration/Web/Default Pages/CMS Home Page - choose Megatron Home + Sidebar.<br />
&nbsp;&nbsp;&nbsp;&nbsp;3. Enable revolution slider in Megatron Layout. Slides content you can get from \app\code\local\Etheme\Megatronrevolution\Model\data_slides_food.xml<br />
&nbsp;&nbsp;&nbsp;&nbsp;4. Set slider height 500 in Megatron Layout/slider.<br />
&nbsp;&nbsp;&nbsp;&nbsp;5. Set Theme Colors/Theme Color #5d8d44.<br />
&nbsp;&nbsp;&nbsp;&nbsp;6. Set Theme Colors/Captions/Font Sanchez.<br />
&nbsp;&nbsp;&nbsp;&nbsp;7. Click refresh css and clear cache.<br /><br />

<b>How Enable Kids subtheme:</b><br />

&nbsp;&nbsp;&nbsp;&nbsp;1. Goto System/Configuration/Design/Themes/Default write \'kids\'.<br />
&nbsp;&nbsp;&nbsp;&nbsp;2. Goto System/Configuration/Web/Default Pages/CMS Home Page - choose Megatron Home Creative.<br />
&nbsp;&nbsp;&nbsp;&nbsp;3. Enable revolution slider in Megatron Layout. Slides content you can get from \app\code\local\Etheme\Megatronrevolution\Model\data_slides_kids.xml<br />
&nbsp;&nbsp;&nbsp;&nbsp;4. Set slider height 700 in Megatron Layout/slider.<br />
&nbsp;&nbsp;&nbsp;&nbsp;5. Set Theme Colors/Theme Color #f60.<br />
&nbsp;&nbsp;&nbsp;&nbsp;6. Set Theme Colors/Captions/Font BubblegumSans.<br />
&nbsp;&nbsp;&nbsp;&nbsp;7. Click refresh css and clear cache.<br /><br />

<b>How Enable Electronics subtheme:</b><br />

&nbsp;&nbsp;&nbsp;&nbsp;1. Goto System/Configuration/Design/Themes/Default write \'electronics\'.<br />
&nbsp;&nbsp;&nbsp;&nbsp;2. Goto System/Configuration/Web/Default Pages/CMS Home Page - choose Megatron Home Izotope.<br />
&nbsp;&nbsp;&nbsp;&nbsp;3. Goto Megatron Layout/Header choose Central Logo.<br />
&nbsp;&nbsp;&nbsp;&nbsp;4. Goto Megatron Layout/Content/Hide \'Services Links (top static block only on HOME PAGE)\' - Yes.<br />
&nbsp;&nbsp;&nbsp;&nbsp;5. Goto Megatron Layout/Slider/Enable simple slider, Use also right banners - yes, Choose CMS static block with banners - Megatron Banners for Simple Slider (dark)<br />
&nbsp;&nbsp;&nbsp;&nbsp;6. Set Theme Colors/Theme Color #1783fc.<br />
&nbsp;&nbsp;&nbsp;&nbsp;7. Set Theme Colors/Captions/Font Exo 2.<br />
&nbsp;&nbsp;&nbsp;&nbsp;8. Click refresh css and clear cache.<br /><br />

</fieldset></div>';
    }
}

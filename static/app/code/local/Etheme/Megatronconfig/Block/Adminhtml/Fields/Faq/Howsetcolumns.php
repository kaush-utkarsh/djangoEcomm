<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howsetcolumns extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_update\'); return false;" href="#" id="how_setcolumns-head">How Set Columns (1-2-3 columns)</a></div>
<input id="how_setcolumns-state" type="hidden" value="1" name="config_state[how_setcolumns]">
<fieldset id="how_setcolumns" class="config collapseable">

<b>To change the home page layout:</b><br />

&nbsp;&nbsp;&nbsp;&nbsp;1. From the Admin menu, select CMS > Pages > Manage Content.<br />
&nbsp;&nbsp;&nbsp;&nbsp;2. Find your home page in the list and click to open the record.<br />
&nbsp;&nbsp;&nbsp;&nbsp;3. In the Page Information panel on the left, select Design. Then in the Page Layout section, set Layout to a different column configuration.<br />
&nbsp;&nbsp;&nbsp;&nbsp;4. When complete, click the Save Page button.<br /><br />

<b>To change the category page layout:</b><br />

&nbsp;&nbsp;&nbsp;&nbsp;1. From the Admin menu, select Catalog > Manage Categories.<br />
&nbsp;&nbsp;&nbsp;&nbsp;2. In the Categories tree, select the category level you want to change.<br />
&nbsp;&nbsp;&nbsp;&nbsp;3. On the Custom Design tab, set Page Layout to “2 columns with right bar.”<br />
&nbsp;&nbsp;&nbsp;&nbsp;4. Click the Save Category button.




</fieldset></div>';
    }
}

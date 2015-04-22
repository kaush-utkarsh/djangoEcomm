<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Htmlgrid extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'grid_template\'); return false;" href="#" id="grid_template-head">Html Responsive Grid</a></div>
<input id="grid_template-state" type="hidden" value="1" name="config_state[grid_template]">
<fieldset id="grid_template" class="config collapseable">
<h4 class="icon-head head-edit-form fieldset-legend">Codes for CMS Pages/Static blocks</h4>

Our theme uses 12-column grid system. This means that for every element you can specify width in grid: from 1 column to 12 columns. These are available grid classes

<ul>
	<li>
		<code>
			.col-md-1, .col-sm-1, .col-lg-1, .col-xs-1<br />
			.col-md-2, .col-sm-2, .col-lg-2, .col-xs-2<br />
			.col-md-3, .col-sm-3, .col-lg-3, .col-xs-3<br />
			.col-md-4, .col-sm-4, .col-lg-4, .col-xs-4<br />
			.col-md-5, .col-sm-5, .col-lg-5, .col-xs-5<br />
			.col-md-6, .col-sm-6, .col-lg-6, .col-xs-6<br />
			.col-md-7, .col-sm-7, .col-lg-7, .col-xs-7<br />
			.col-md-8, .col-sm-8, .col-lg-8, .col-xs-8<br />
			.col-md-9, .col-sm-9, .col-lg-9, .col-xs-9<br />
			.col-md-10, .col-sm-10, .col-lg-10, .col-xs-10<br />
			.col-md-11, .col-sm-11, .col-lg-11, .col-xs-11<br />
			.col-md-12, .col-sm-12, .col-lg-12, .col-xs-12<br /><br />

			<h2>2 columns</h2>
            For example, if you want to show content on your  page in two equal columns, use grid classes like this:
            <br /><br />
            <pre>
            &lt;div class="row"&gt;
                &lt;div class="col-md-6 col-sm-6 col-lg-6 col-xs-6"&gt;COL-1&lt;/div&gt;
                &lt;div class="col-md-6 col-sm-6 col-lg-6 col-xs-6"&gt;COL-2&lt;/div&gt;
            &lt;/div&gt;
            </pre>

            <h2>3 columns</h2>
            For example, if you want to show content on your  page in three equal columns, use grid classes like this:
            <br /><br />
            <pre>
            &lt;div class="row"&gt;
                &lt;div class="col-md-4 col-sm-4 col-lg-4 col-xs-4"&gt;COL-1&lt;/div&gt;
                &lt;div class="col-md-4 col-sm-4 col-lg-4 col-xs-4"&gt;COL-2&lt;/div&gt;
                &lt;div class="col-md-4 col-sm-4 col-lg-4 col-xs-4"&gt;COL-3&lt;/div&gt;
            &lt;/div&gt;
            </pre>

            <h2>4 columns</h2>
            For example, if you want to show content on your  page in three equal columns, use grid classes like this:
            <br /><br />
            <pre>
            &lt;div class="row"&gt;
                &lt;div class="col-md-3 col-sm-3 col-lg-3 col-xs-3"&gt;COL-1&lt;/div&gt;
                &lt;div class="col-md-3 col-sm-3 col-lg-3 col-xs-3"&gt;COL-2&lt;/div&gt;
                &lt;div class="col-md-3 col-sm-3 col-lg-3 col-xs-3"&gt;COL-3&lt;/div&gt;
                &lt;div class="col-md-3 col-sm-3 col-lg-3 col-xs-3"&gt;COL-4&lt;/div&gt;
            &lt;/div&gt;
            </pre>

            where <b>-md -sm -lg -xs</b>  suffixes for different resolutions, <a href="http://getbootstrap.com/css/" target="blank">here</a> you can learn more about in "Grid system" section

		</code>
	</li>
</ul>






</fieldset></div>';
    }
}

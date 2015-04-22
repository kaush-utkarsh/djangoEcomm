<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Howcatslider extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
       // $layout  =  Mage::helper('grid')->returnlayout();
        //$block = Mage::helper('grid')->returnblock();
        //$text =  Mage::helper('grid')->returntext();
       // $template = Mage::helper('grid')->returntemplate();
        return '
<div class="section-config">
<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'how_docatslider\'); return false;" href="#" id="how_docatslider-head">How do category slider</a></div>
<input id="how_docatslider-state" type="hidden" value="1" name="config_state[how_docatslider]">
<fieldset id="how_docatslider" class="config collapseable">

Upload needed slides with recommended width 1171px and height 208px like in demo in folder media/wysiwyg/<br />
Create any Cms/Static block with any Block Title and Identifier, for ex. Category Woman Slider.<br />
Paste in content area next code:<br /><br />


          <pre><b>
          &lt;section class="owl-slider-outer slider-listing hidden-xs"&gt;
            &lt;div class="owl-slider category"&gt;
              &lt;div class="item"&gt;&lt;img src="{{media url=wysiwyg/SLIDE_NAME.jpg}}" alt=""&gt;
                &lt;div class="listing-title women hidden-xs"&gt;
                  &lt;h1&gt;Women&lt;/h1&gt;
                &lt;/div&gt;
              &lt;/div&gt;
              &lt;div class="item"&gt;&lt;img src="{{media url=wysiwyg/SLIDE_NAME.jpg}}" alt=""&gt;
                &lt;div class="listing-title women hidden-xs"&gt;
                  &lt;h1&gt;Women&lt;/h1&gt;
                &lt;/div&gt;
              &lt;/div&gt;
            &lt;/div&gt;
          &lt;/section&gt;
          &lt;p&gt;Vestibulum justo. Nulla mauris ipsum, convallis ut, vestibulum eu, tincidunt vel, nisi. Curabitur molestie euismod erat.
          Proin eros odio, mattis rutrum. et, egestas vitae, magna. Integer semper, velit ut interNam lectus nulla, bibendum pretium, dictum a, mattis nec, dolor. Nullam id justo sed diam aliquam tincidunt.
          Duis sollicitudin, dui ac commodo iaculis, mi risus sagittis odio, vel ultrices enim sem ut pede. Aenean quam. Nulla neque purus, ullamcorper nec, eleifend at, fermentum ut, turpis. Nullam id justo
          sed labore diam diam aliquam nonumy. Integer ligula magna, dictum et, pulvinar non, ultricies ac, nibh. Vivamus euismod nulla vel nunc. Fusce tincidunt, justo congue egestas molestie, tortor tortor
          blandit erat, et scelerisque metus metus at ipsum.&lt;/p&gt;</b>

          </pre>
In admin click on any category / click Display settings tab / Display Mode set \'Static block and products\' / select your Static Block / Save / Flush Cache

</fieldset></div>';
    }
}

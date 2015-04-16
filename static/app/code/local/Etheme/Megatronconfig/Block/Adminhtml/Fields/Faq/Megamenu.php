<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Megamenu extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
      
        return '
<div class="section-config">

<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'megamenu\'); return false;" href="#" id="megamenu-head">Topmenu</a>
</div>

<input id="megamenu-state" type="hidden" value="1" name="config_state[megamenu]">
<fieldset id="megamenu" class="config collapseable"  >
<h4 class="icon-head head-edit-form fieldset-legend">Topmenu consists of three main parts - Left Part (static block), Central(Categories) Part, Right Part (static block)</h4>
<br />
<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'etheme/megatron/adminhtml/megamenu_1.png" />

<ul>
	<li>
		<code>

IF you use Megamenu then <b>left</b> part you have to edit in this cms block - <b>mtron_topmenu_megamenu_left</b> <br />
IF you use Megamenu then <b>right</b> part you have to edit in this cms block - <b>mtron_topmenu_megamenu_right</b> <br /><br />

IF you disabled Megamenu then <b>left</b> part you have to edit in this cms block - <b>mtron_topmenu_simple_left</b> <br />
IF you disabled Megamenu then <b>right</b> part you have to edit in this cms block - <b>mtron_topmenu_simple_right</b> <br /><br />

Mobile version of topmenu uses also own top and bottom static blocks <br />
For mobile version menu <b>top</b> part you have to edit in this cms block - <b>mtron_topmenu_mobile_top</b> <br />
For mobile version menu <b>bottom</b> part you have to edit in this cms block - <b>mtron_topmenu_mobile_btm</b> <br /><br />


<hr /><br />
<b>Q: I need have only home button in topmenu, but I don\'t want use left part menu. What i need to edit?</b><br/>
A:You need go to CMS/Static blocks and choose mtron_topmenu_megamenu_left/mtron_topmenu_simple_left/mtron_topmenu_mobile_top . <br />
You will see code smth like this<br /><br />

 &lt;ul class="sf-menu"&gt;<br />
            &lt;li&gt;&lt;a href="{{store url=\'\'}}" class="btn-main"&gt;&lt;span class="icon icon-home"&gt;&lt;/span&gt;&lt;/a&gt;<br />
                &lt;ul&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Lorem Ipsum&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Ipsum Dolor&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Lorem Ipsum&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Ipsum Dolor&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Lorem Ipsum&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Ipsum Dolor&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Lorem Ipsum&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;a href="#"&gt;Ipsum Dolor&lt;/a&gt;&lt;/li&gt;<br />

                &lt;/ul&gt;<br />
            &lt;/li&gt;<br />
        &lt;/ul&gt;<br />
    &lt;/dt&gt;<br />
    &lt;dd&gt;&lt;/dd&gt;<br />
		&lt;/code&gt;<br />
	&lt;/li&gt;<br />
&lt;/ul&gt;<br /><br />

    <br />Delete extra code. You need have next<br /><br />

    &lt;ul class="sf-menu"&gt;<br />
                &lt;li&gt;&lt;a href="{{store url=\'\'}}" class="btn-main"&gt;&lt;span class="icon icon-home"&gt;&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;<br />
        &lt;/ul&gt;<br />
    &lt;/dt&gt;<br />
    &lt;dd&gt;&lt;/dd&gt;<br /><br />

    , where <b>{{store url=\'\'}}</b> - link to home page


<hr /><br />
<b>Q: How can I to do Megamenu like in your demo?</b><br/>
A:Goto Catalog/Manage categories. You need Select 1st level categories. Root is 0-level. You will see Megamenu tab
<br />
<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'etheme/megatron/adminhtml/megamenu_2.png" />

<hr /><br />
<b>Q: How can I to do next blocks like in your demo? </b><br/>
<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'etheme/megatron/adminhtml/megamenu_3.png" /><br />
A:Goto Catalog/Manage categories. You need Select 1st level category. Select Megamenu tab.<br />
In fields \'Html block above menu\' and \'Html block under menu\' you can paste <br />
smth like this<br /><br />
&lt;ul class="exclusive"&gt;<br />
                    &lt;li&gt;&lt;span class="icon icon-dropbox"&gt;&lt;/span&gt; &lt;a href="#"&gt;Gifts exclusive&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;span class="icon icon-coins"&gt;&lt;/span&gt; &lt;a href="#"&gt;Offers&lt;/a&gt;&lt;/li&gt;<br />
                  &lt;/ul&gt;<br /><br />
or<br />
smth like this<br /><br />
&lt;ul class="exclusive"&gt;<br />
                    &lt;li&gt;&lt;span class="icon icon-tag "&gt;&lt;/span&gt; &lt;a href="#"&gt;SPECIAL OFFER&lt;/a&gt;&lt;/li&gt;<br />
                    &lt;li&gt;&lt;span class="icon icon-sale"&gt;&lt;/span&gt; &lt;a href="#"&gt;UP TO 50% OFF DISCOUNTS&lt;/a&gt;&lt;/li&gt;<br />
                  &lt;/ul&gt;<br />


<hr /><br />
<b>Q: I do\'nt see Megamenu tab!</b><br/>
A:Seems like Magento system not writed required attributes from \app\code\local\Etheme\Megatronconfig\sql\megatronconfig_setup\mysql4-install-0.1.0.php<br />
You need open your MySql database with PhpMyAdmin -> find table <b>core_resource</b> -> find line with code <b>megatronconfig_setup</b> and delete it.<br />
Goto magento admin panel -> system ->Index Management -> Reindex all<br />
Goto magento admin panel -> system ->Cache Management -> Flush Cache<br />
<br />




</code>
	</li>
</ul>





</fieldset>
</div>
';
    }
}

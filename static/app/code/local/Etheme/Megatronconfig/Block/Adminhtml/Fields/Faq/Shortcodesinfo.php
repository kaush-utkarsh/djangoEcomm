<?php

class Etheme_Megatronconfig_Block_Adminhtml_Fields_Faq_Shortcodesinfo extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
      
        return '
<div class="section-config">

<div class="entry-edit-head collapseable">
<a onclick="Fieldset.toggleCollapse(\'bannerslider_template\'); return false;" href="#" id="bannerslider_template-head">Shortcodes</a>
</div>

<input id="bannerslider_template-state" type="hidden" value="1" name="config_state[bannerslider_template]">
<fieldset id="bannerslider_template" class="config collapseable"  >
<h4 class="icon-head head-edit-form fieldset-legend">Codes for CMS Pages/Static blocks</h4>

<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('Horizontal Products Carousel (count of visible items depends of carousel wrapper width). This type of shortcode outputs products from category as carousel').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>
			{{block type="catalog/product_list" category_id="N"  block_name="Title" template="carousel/products_horizontal.phtml"}}
			<br/>
			where<br/>
			<b>N</b> - any category id (you can create any inactive category named as carousel name)<br/>
			<b>block_name</b> - any Title, for example Sale products / Bestsellers / Featured / Top Rated<br/>
		</code>
	</li>
</ul>

<br>
<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('Vertical Products Carousel (only 3 items visible). This type of shortcode outputs products from category as carousel').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>
			{{block type="catalog/product_list" category_id="N"  block_name="Title" template="carousel/products_vertical.phtml"}}
			<br/>
			where<br/>
			<b>N</b> - any category id (you can create any inactive category named as carousel name)<br/>
			<b>block_name</b> - any Title, for example Sale products / Bestsellers / Featured / Top Rated<br/>
		</code>
	</li>
</ul>

<br>
<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('New Products Carousel Horizontal(count of visible items depends of carousel wrapper width). This type of shortcode outputs products from category as carousel').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>
			 {{block type="catalog/product_new" products_count="8" block_name="New Products"  template="carousel/products_new_horizontal.phtml" }}

		</code>
	</li>
</ul>
<br>
<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('New Products Carousel Vertical(only 3 items visible). This type of shortcode outputs products from category as carousel').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>
			 {{block type="catalog/product_new" products_count="8" block_name="New Products"  template="carousel/products_new_vertical.phtml" }}

		</code>
	</li>
</ul>
<br>
<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('Products Grid(visible all products from category). This type of shortcode outputs products from category as grid').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>
			<h3>block_name</h3>
            <div class="row products-list">
               {{block type="catalog/product_list" category_id="N"  block_name="block_name" template="izotope/products_from_category.phtml"}}
            </div>
            <div class="line-divider divider-xxs"></div>
            <br/>

			where<br/>
			<b>N</b> - any category id (you can create any inactive category named as carousel name)<br/>
			<b>block_name</b> - any Title, for example Sale products / Bestsellers / Featured / Top Rated<br/>
		</code>
	</li>
</ul>

<br>
<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('Products Izotop Grid(visible all products New/Sale/Bestsellers/Top Rated). This type of shortcode outputs products  as grid with filter').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>

			&lt;!-- Filters --&gt;<br />
            &lt;section class="filters-by-category clearfix"&gt;<br />
                &lt;div class="container"&gt;<br />
                    &lt;div class="row"&gt;<br />
                        &lt;div class="text-center"&gt;<br />
                            &lt;ul class="option-set" data-option-key="filter"&gt;<br />
                                &lt;li&gt;&lt;a href="#filter" data-option-value="*" class="selected"&gt;all&lt;/a&gt;&lt;/li&gt;<br />
                                &lt;li&gt;&lt;a href="#filter" data-option-value=".category_id_N"&gt;BEST SELLERS&lt;/a&gt;&lt;/li&gt;<br />
                                &lt;li&gt;&lt;a href="#filter" data-option-value=".new"&gt;New Products&lt;/a&gt;&lt;/li&gt;<br />
                                &lt;li&gt;&lt;a href="#filter" data-option-value=".category_id_10"&gt;On Sale&lt;/a&gt;&lt;/li&gt;<br />
                                &lt;li&gt;&lt;a href="#filter" data-option-value=".category_id_15"&gt;Top Rated&lt;/a&gt;&lt;/li&gt;<br />
                            &lt;/ul&gt;<br />
                        &lt;/div&gt;<br />
                    &lt;/div&gt;<br />
                &lt;/div&gt;<br />
            &lt;/section&gt;<br />
            &lt;!-- //end Filters --&gt;<br />

            &lt;!-- Isotope Products --&gt;<br />
            &lt;section class="container content slider-products"&gt;<br />
            &lt;!-- Products list --&gt;<br />
                &lt;div class="row"&gt;<br />
                    &lt;div class="products-list-isotope"&gt;<br />
                        {{block type="catalog/product_list" category_id="N"  block_name="Bestsellers" template="izotope/products_from_category.phtml"}}<br />
                        {{block type="catalog/product_new" cache_lifetime="1" products_count="10"  template="izotope/products_new.phtml"  block_name="New Products"}}<br />
                        {{block type="catalog/product_list" category_id="10"  block_name="On Sale" template="izotope/products_from_category.phtml"}}<br />
                        {{block type="catalog/product_list" category_id="15"  block_name="Top Rated" template="izotope/products_from_category.phtml"}}<br />
                    &lt;/div&gt;<br />
                &lt;/div&gt;<br />
            &lt;/section&gt;<br />

            <br/>
			<br/>
			<b>N</b> - any category id (you can create any inactive category named as carousel name)<br/>
			<b>block_name</b> - any Title, for example Sale products / Bestsellers / Featured / Top Rated<br/>

			<br />
            <img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'etheme/megatron/adminhtml/shortcode_1.png" />

            <br/>
            Ready izotop home page you can find in CMS/Pages megatron_home_izotope
		</code>
	</li>
</ul>

<br>
<div id="messages">
    <ul class="messages">
        <li class="notice-msg">
            <ul>
                <li>'.Mage::helper('megatronconfig')->__('How to put any cms static block in cms page').'</li>
            </ul>
        </li>
    </ul>
</div>
<br>
<ul>
	<li>
		<code>
			 {{block type="cms/block" block_id="static_block_identifier" template="cms/content.phtml"}}
            <br/>
			where<br/>
			<b>block_id</b> - unique static block identifier, for ex. mtron_brands<br/>
		</code>
	</li>
</ul>




</fieldset>
</div>
';
    }
}

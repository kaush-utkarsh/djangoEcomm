<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alesioo
 * Date: 12.12.12
 * Time: 16:24
 * To change this template use File | Settings | File Templates.
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

Mage::getConfig()->saveConfig('cms/wysiwyg/enabled', 'hidden');

/**
 * Adding Different Attributes
 */
$setup->addAttributeGroup('catalog_product', 'Default', 'Video', 1000);

$setup->addAttribute('catalog_product', 'videobox', array(
    'group'         => 'Video',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Video youtube url',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'note'=>'ex. http://www.youtube.com/embed/L9szn1QQfas  <br />    if you want autoplay then add ?autoplay=1',
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_product', 'customtabtitle', array(
    'group'         => 'Custom Tab',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Custom Tab Title',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_product', 'customtab', array(
    'group'         => 'Custom Tab',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Custom Tab',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_category', 'menutopdescription1', array(
    'group'         => 'Megamenu',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Topmenu description for megamenu "type A"',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This field is compatible only with 1st-level category. For ex. paste next html code to show image <br />'.htmlentities("<div class='img-fullheight'>
<img class='img-responsiv' src='{{media url=wysiwyg/menu-img-right.png}}' alt=''></div>"),
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_category', 'bs_top_html', array(
    'group'         => 'Megamenu',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Html block above menu',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This field is compatible only with 1st-level category',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_category', 'bs_btm_html', array(
    'group'         => 'Megamenu',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Html block under menu',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This field is compatible only with 1st-level category',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_category', 'bs_small_cat_desc', array(
    'group'         => 'Megamenu',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Small category description for megamenu "type B"',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This field is compatible only with 2nd-level category',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_category', 'bs_count_columns', array(
    'group'         => 'Megamenu',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Count of columns',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This field is compatible only with 1st-level category. Only 2 or 3 or 4 or 6. If field Topmenu description not empty then only 2 or 3 or 4',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_category', 'bs_category_lable', array(
    'group'         => 'Megamenu',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Category lable, for ex. "Hot!"',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This field is compatible only with 2nd-level category megamenu "type A"',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_category', 'bs_category_icon', array(
    'group'         => 'Megamenu',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Category Icon',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'Write Icon Code. Icon Code you can take here. For ex. write m-icon-coats. Icons disabled in Megamenu "type B". This field is compatible only with 2nd-level category',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));







$eavConfig = Mage::getSingleton('eav/config');

$attribute_2 = $eavConfig->getAttribute('catalog_category', 'bs_top_html');
$attribute_2->setData('is_wysiwyg_enabled', 1);
$attribute_2->save();

$attribute_3 = $eavConfig->getAttribute('catalog_category', 'bs_btm_html');
$attribute_3->setData('is_wysiwyg_enabled', 1);
$attribute_3->save();





$installer->endSetup();
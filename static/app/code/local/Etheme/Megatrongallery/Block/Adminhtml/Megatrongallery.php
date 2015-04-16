<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatrongallery_Block_Adminhtml_Megatrongallery extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_megatrongallery';
		$this->_blockGroup = 'megatrongallery';
		$this->_headerText = Mage::helper('megatrongallery')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('megatrongallery')->__('Add Item');
		parent::__construct();
	}
}
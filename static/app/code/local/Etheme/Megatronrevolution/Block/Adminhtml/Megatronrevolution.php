<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrevolution_Block_Adminhtml_Megatronrevolution extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_megatronrevolution';
		$this->_blockGroup = 'megatronrevolution';
		$this->_headerText = Mage::helper('megatronrevolution')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('megatronrevolution')->__('Add Item');
		parent::__construct();
	}
}
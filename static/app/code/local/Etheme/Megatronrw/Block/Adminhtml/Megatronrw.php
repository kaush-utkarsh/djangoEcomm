<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrw_Block_Adminhtml_Megatronrw extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_megatronrw';
		$this->_blockGroup = 'megatronrw';
		$this->_headerText = Mage::helper('megatronrw')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('megatronrw')->__('Add Item');
		parent::__construct();
	}
}
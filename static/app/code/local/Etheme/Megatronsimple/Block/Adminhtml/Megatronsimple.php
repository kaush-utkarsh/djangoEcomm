<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronsimple_Block_Adminhtml_Megatronsimple extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_megatronsimple';
		$this->_blockGroup = 'megatronsimple';
		$this->_headerText = Mage::helper('megatronsimple')->__('Flex Slider');
		$this->_addButtonLabel = Mage::helper('megatronsimple')->__('Add Item');
		parent::__construct();
	}
}
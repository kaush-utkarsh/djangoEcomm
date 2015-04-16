<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Header
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'default','label' => Mage::helper('megatronconfig')->__('Default')),
            array('value'=>'minimize','label' => Mage::helper('megatronconfig')->__('Minimize')),
            array('value'=>'central','label' => Mage::helper('megatronconfig')->__('Central Logo')),
            array('value'=>'advanced','label' => Mage::helper('megatronconfig')->__('Advanced')),
        );
    }
}

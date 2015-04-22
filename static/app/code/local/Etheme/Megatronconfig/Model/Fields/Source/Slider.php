<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Slider
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'megatron','label' => Mage::helper('megatronconfig')->__('Megatron')),
            array('value'=>'revolution','label' => Mage::helper('megatronconfig')->__('Revolution layered slider')),
            array('value'=>'revolution_advanced','label' => Mage::helper('megatronconfig')->__('Revolution Advanced layered slider')),
            array('value'=>'simple','label' => Mage::helper('megatronconfig')->__('Simple slider')),
        );
    }
}

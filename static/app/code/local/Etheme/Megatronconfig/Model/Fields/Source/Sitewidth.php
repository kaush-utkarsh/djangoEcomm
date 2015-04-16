<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Sitewidth
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'width_1170','label' => Mage::helper('megatronconfig')->__('1170px')),
            array('value'=>'width_1400','label' => Mage::helper('megatronconfig')->__('1400px')),
            array('value'=>'width_1600','label' => Mage::helper('megatronconfig')->__('1600px')),
        );
    }
}

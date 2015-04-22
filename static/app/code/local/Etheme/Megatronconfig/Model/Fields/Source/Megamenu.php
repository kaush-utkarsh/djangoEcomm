<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Megamenu
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'type_a','label' => Mage::helper('megatronconfig')->__('Type A')),
            array('value'=>'type_b','label' => Mage::helper('megatronconfig')->__('Type B (disabled field Topmenu description)')),
        );
    }
}

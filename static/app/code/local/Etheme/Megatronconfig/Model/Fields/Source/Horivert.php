<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Horivert
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'hor','label' => Mage::helper('megatronconfig')->__('Horizontal')),
            array('value'=>'ver','label' => Mage::helper('megatronconfig')->__('Vertical')),
        );
    }
}

<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Leftbottom
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'left','label' => Mage::helper('megatronconfig')->__('Left')),
            array('value'=>'bottom','label' => Mage::helper('megatronconfig')->__('Bottom')),
        );
    }
}

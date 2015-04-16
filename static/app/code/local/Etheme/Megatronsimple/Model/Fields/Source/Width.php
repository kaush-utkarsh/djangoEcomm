<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronsimple_Model_Fields_Source_Width
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'wide','label' => Mage::helper('megatronconfig')->__('Wide')),
            array('value'=>'fixed','label' => Mage::helper('megatronconfig')->__('Fixed')),
        );
    }
}

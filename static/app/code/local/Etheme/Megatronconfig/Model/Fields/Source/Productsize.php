<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Productsize
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'small','label' => Mage::helper('megatronconfig')->__('Small')),
            array('value'=>'big','label' => Mage::helper('megatronconfig')->__('Big')),
        );
    }
}

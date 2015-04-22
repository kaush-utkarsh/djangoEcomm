<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Productlistingmode
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'simple','label' => Mage::helper('megatronconfig')->__('Simple (image only)')),
            array('value'=>'usual','label' => Mage::helper('megatronconfig')->__('Usual (description, price)')),
        );
    }
}

<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Quickview
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'in','label' => Mage::helper('megatronconfig')->__('Inline')),
            array('value'=>'out','label' => Mage::helper('megatronconfig')->__('Popup')),
        );
    }

}

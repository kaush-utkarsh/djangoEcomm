<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Relatedstyle
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'visible_1','label' => Mage::helper('megatronconfig')->__('Visible products 1')),
            array('value'=>'visible_3','label' => Mage::helper('megatronconfig')->__('Visible products 3')),
        );
    }
}

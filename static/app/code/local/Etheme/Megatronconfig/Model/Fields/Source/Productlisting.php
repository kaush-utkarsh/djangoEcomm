<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Productlisting
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'classic','label' => Mage::helper('megatronconfig')->__('classic')),
            array('value'=>'izotope','label' => Mage::helper('megatronconfig')->__('izotope')),
        );
    }
}

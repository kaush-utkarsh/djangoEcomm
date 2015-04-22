<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Gallerygrid
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'columns_2','label' => Mage::helper('megatronconfig')->__('2 in row')),
            array('value'=>'columns_3','label' => Mage::helper('megatronconfig')->__('3 in row')),
            array('value'=>'columns_4','label' => Mage::helper('megatronconfig')->__('4 in row')),
            array('value'=>'columns_4_no_space','label' => Mage::helper('megatronconfig')->__('4 in row without space')),
        );
    }
}

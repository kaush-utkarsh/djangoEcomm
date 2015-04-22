<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Model_Fields_Source_Videopos
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'with_thumbs','label' => Mage::helper('megatronconfig')->__('With thumbnails')),
            array('value'=>'under_tabs','label' => Mage::helper('megatronconfig')->__('Under tabs')),
        );
    }
}

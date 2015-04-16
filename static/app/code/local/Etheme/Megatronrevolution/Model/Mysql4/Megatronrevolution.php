<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrevolution_Model_Mysql4_Megatronrevolution extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('megatronrevolution/megatronrevolution', 'slide_id');
    }

}
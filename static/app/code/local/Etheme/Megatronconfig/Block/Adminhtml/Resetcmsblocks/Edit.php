<?php
class Etheme_Megatronconfig_Block_Adminhtml_Resetcmsblocks_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_resetcmsblocks';
        $this->_blockGroup = 'megatronconfig';
        $this->_updateButton('save', 'label', Mage::helper('megatronconfig')->__('Submit Action'));
        $this->_removeButton('back');
    }

    public function getHeaderText()
    {
        return Mage::helper('megatronconfig')->__('Reset CMS blocks/pages to default');
    }
}

?>
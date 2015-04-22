<?php
class Etheme_Megatronconfig_Block_Adminhtml_Installtemplate_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_installtemplate';
        $this->_blockGroup = 'megatronconfig';
        $this->_updateButton('save', 'label', Mage::helper('megatronconfig')->__('Auto install'));
        $this->_removeButton('back');
    }

    public function getHeaderText()
    {
        return Mage::helper('megatronconfig')->__('Megatron Install');
    }
}

?>
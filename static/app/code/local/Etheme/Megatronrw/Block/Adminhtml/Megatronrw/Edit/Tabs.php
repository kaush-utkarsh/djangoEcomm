<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrw_Block_Adminhtml_Megatronrw_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('megatronrw_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('megatronrw')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('megatronrw')->__('Slide Information. <br /><br /> You can edit slider file here \app\design\frontend\megatron\default\template\megatron\slider\slider_megatron.phtml'),
          'title'     => Mage::helper('megatronrw')->__('Slide Information. '),
          'content'   => $this->getLayout()->createBlock('megatronrw/adminhtml_megatronrw_edit_tab_form')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}
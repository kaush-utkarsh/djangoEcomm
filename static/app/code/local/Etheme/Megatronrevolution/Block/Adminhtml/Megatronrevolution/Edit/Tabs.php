<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrevolution_Block_Adminhtml_Megatronrevolution_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('megatronrevolution_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('megatronrevolution')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('megatronrevolution')->__('Slide Information<br /><br /> You can edit slider file here \app\design\frontend\megatron\default\template\megatron\slider\slider_revolution.phtml'),
          'title'     => Mage::helper('megatronrevolution')->__('Slide Information'),
          'content'   => $this->getLayout()->createBlock('megatronrevolution/adminhtml_megatronrevolution_edit_tab_form')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}
<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronsimple_Block_Adminhtml_Megatronsimple_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('megatronsimple_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('megatronsimple')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('megatronsimple')->__('Slide Information<br /><br /> You can edit slider file here \app\design\frontend\megatron\default\template\megatron\slider\slider_simple.phtml'),
          'title'     => Mage::helper('megatronsimple')->__('Slide Information'),
          'content'   => $this->getLayout()->createBlock('megatronsimple/adminhtml_megatronsimple_edit_tab_form')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}
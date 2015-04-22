<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatrongallery_Block_Adminhtml_Megatrongallery_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('megatrongallery_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('megatrongallery')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('megatrongallery')->__('Item Information.'),
          'title'     => Mage::helper('megatrongallery')->__('Item Information. '),
          'content'   => $this->getLayout()->createBlock('megatrongallery/adminhtml_megatrongallery_edit_tab_form')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}
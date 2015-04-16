<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrevolution_Block_Adminhtml_Megatronrevolution_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset_slide = $form->addFieldset('megatronrevolution_form_2', array('legend'=>Mage::helper('megatronrevolution')->__('Slide data')));
      //$fieldset = $form->addFieldset('megatronrevolution_form', array('legend'=>Mage::helper('megatronrevolution')->__('Create your revolution slide by preset options (only if you did not fill the "Slide HTML code")')));


	  $data = array();
	  if (Mage::getSingleton('adminhtml/session')->getmegatronrevolutionData())
      {
	  	$data = Mage::getSingleton('adminhtml/session')->getmegatronrevolutionData();
	  } elseif ( Mage::registry('megatronrevolution_data') ) {
		$data = Mage::registry('megatronrevolution_data')->getData();
	  }


      if (!Mage::app()->isSingleStoreMode()) {
          $fieldset_slide->addField('store_id', 'multiselect', array(
              'name' => 'stores[]',
              'label' => Mage::helper('megatronrevolution')->__('Store View'),
              'title' => Mage::helper('megatronrevolution')->__('Store View'),
              'required' => true,
              'values' => Mage::getSingleton('adminhtml/system_store')
                  ->getStoreValuesForForm(false, true),
          ));
      }
      else {
          $fieldset_slide->addField('store_id', 'hidden', array(
              'name' => 'stores[]',
              'value' => Mage::app()->getStore(true)->getId()
          ));
      }

      $fieldset_slide->addField('link', 'text', array(
          'label'     => Mage::helper('megatronrevolution')->__('Link'),
          'required'  => false,
          'name'      => 'link',
          'index'      => 'link',
      ));

      $fieldset_slide->addField('slide_html_code', 'textarea', array(
          'label'     => Mage::helper('megatronrevolution')->__('Slide HTML code'),
          'required'  => false,
          'name'      => 'slide_html_code',
          'index'      => 'slide_html_code',
          'note'=>'You can copy slides backup code from \app\code\local\Etheme\Megatronrevolution\Model\data_slides_advanced.xml'
      ));

      $fieldset_slide->addField('status', 'select', array(
          'label'     => Mage::helper('megatronrevolution')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('megatronrevolution')->__('Active'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('megatronrevolution')->__('Inactive'),
              ),
          ),
      ));

      if ( Mage::getSingleton('adminhtml/session')->getmegatronrevolutionData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getmegatronrevolutionData());
          Mage::getSingleton('adminhtml/session')->setmegatronrevolutionData(null);
      } elseif ( Mage::registry('megatronrevolution_data') ) {
          $form->setValues(Mage::registry('megatronrevolution_data')->getData());
      }
      return parent::_prepareForm();
  }
}
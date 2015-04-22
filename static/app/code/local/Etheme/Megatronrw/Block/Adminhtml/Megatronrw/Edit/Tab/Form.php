<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronrw_Block_Adminhtml_Megatronrw_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset_slide = $form->addFieldset('megatronrw_form_2', array('legend'=>Mage::helper('megatronrw')->__('Slide data')));
      //$fieldset = $form->addFieldset('megatronrw_form', array('legend'=>Mage::helper('megatronrw')->__('Create your parallax slide by preset options (only if you did not fill the "Slide HTML code")')));


	  $data = array();
	  if (Mage::getSingleton('adminhtml/session')->getmegatronrwData())
      {
	  	$data = Mage::getSingleton('adminhtml/session')->getmegatronrwData();
	  } elseif ( Mage::registry('megatronrw_data') ) {
		$data = Mage::registry('megatronrw_data')->getData();
	  }


      if (!Mage::app()->isSingleStoreMode()) {
          $fieldset_slide->addField('store_id', 'multiselect', array(
              'name' => 'stores[]',
              'label' => Mage::helper('megatronrw')->__('Store View'),
              'title' => Mage::helper('megatronrw')->__('Store View'),
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
          'label'     => Mage::helper('megatronrw')->__('Link'),
          'required'  => false,
          'name'      => 'link',
          'index'      => 'link',
      ));

      $data = array();
      if ( Mage::getSingleton('adminhtml/session')->getmegatronrwData() )
      {
          $data = Mage::getSingleton('adminhtml/session')->getmegatronrwData();
      } elseif ( Mage::registry('megatronrw_data') ) {
          $data = Mage::registry('megatronrw_data')->getData();
      }

      $imgfront='';
      if (!empty($data['image']) )$imgfront = '<br/><a href="' . Mage::getBaseUrl('media').$data['image'] . '" target="_blank" >'."<img src=" . Mage::getBaseUrl('media').$data['image'] . " width='200px' alt='' /></a>";

      $fieldset_slide->addField('image', 'file', array(
          'label'     => Mage::helper('megatronrw')->__('Slide Image'),
          'name'      => 'image',
          'note' => $imgfront,
      ));

      $fieldset_slide->addField('caption', 'textarea', array(
          'label'     => Mage::helper('megatronrw')->__('Caption'),
          'required'  => false,
          'name'      => 'caption',
          'index'      => 'caption',
          'note'=>'You can copy slides backup code from \app\code\local\Etheme\Megatronrw\Model\data_slides.xml'
      ));

      $fieldset_slide->addField('leftpos', 'text', array(
          'label'     => Mage::helper('megatronrw')->__('Caption Left Position, %'),
          'required'  => false,
          'name'      => 'leftpos',
          'index'      => 'leftpos',
          'note'=>'default 10'
      ));

      $fieldset_slide->addField('toppos', 'text', array(
          'label'     => Mage::helper('megatronrw')->__('Caption Top Position, %'),
          'required'  => false,
          'name'      => 'toppos',
          'index'      => 'toppos',
          'note'=>'default 40'
      ));

      $fieldset_slide->addField('width', 'text', array(
          'label'     => Mage::helper('megatronrw')->__('Caption Width, %'),
          'required'  => false,
          'name'      => 'width',
          'index'      => 'width',
          'note'=>'default 100'
      ));

      $fieldset_slide->addField('extra', 'text', array(
          'label'     => Mage::helper('megatronrw')->__('Caption Extra css'),
          'required'  => false,
          'name'      => 'extra',
          'index'     => 'extra',
          'note'      => 'You can write here css code separated by ; for ex. text-align:center;font-weight:bold',
      ));

      $fieldset_slide->addField('status', 'select', array(
          'label'     => Mage::helper('megatronrw')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('megatronrw')->__('Active'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('megatronrw')->__('Inactive'),
              ),
          ),
      ));

      if ( Mage::getSingleton('adminhtml/session')->getmegatronrwData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getmegatronrwData());
          Mage::getSingleton('adminhtml/session')->setmegatronrwData(null);
      } elseif ( Mage::registry('megatronrw_data') ) {
          $form->setValues(Mage::registry('megatronrw_data')->getData());
      }
      return parent::_prepareForm();
  }
}
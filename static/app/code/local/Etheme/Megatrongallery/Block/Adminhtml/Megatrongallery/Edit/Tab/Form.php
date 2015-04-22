<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatrongallery_Block_Adminhtml_Megatrongallery_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset_slide = $form->addFieldset('megatrongallery_form_2', array('legend'=>Mage::helper('megatrongallery')->__('Item data')));
      //$fieldset = $form->addFieldset('megatrongallery_form', array('legend'=>Mage::helper('megatrongallery')->__('Create your parallax slide by preset options (only if you did not fill the "Slide HTML code")')));


	  $data = array();
	  if (Mage::getSingleton('adminhtml/session')->getmegatrongalleryData())
      {
	  	$data = Mage::getSingleton('adminhtml/session')->getmegatrongalleryData();
	  } elseif ( Mage::registry('megatrongallery_data') ) {
		$data = Mage::registry('megatrongallery_data')->getData();
	  }


      if (!Mage::app()->isSingleStoreMode()) {
          $fieldset_slide->addField('store_id', 'multiselect', array(
              'name' => 'stores[]',
              'label' => Mage::helper('megatrongallery')->__('Store View'),
              'title' => Mage::helper('megatrongallery')->__('Store View'),
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

      /*$fieldset_slide->addField('link', 'text', array(
          'label'     => Mage::helper('megatrongallery')->__('Direct Link'),
          'required'  => false,
          'name'      => 'link',
          'index'      => 'link',
          'class' =>'validate-clean-url'
      ));

      $fieldset_slide->addField('page_id', 'text', array(
          'label'     => Mage::helper('megatrongallery')->__('Link to cms page'),
          'required'  => false,
          'name'      => 'link',
          'index'      => 'link',
          'note'=>'write cms page URL Key. Direct link will be ignored',
          'class'=>'validate-identifier'
      ));*/


      $categories=explode(',',Mage::getStoreConfig('megatronlayout/options/gallery_categories'));
      $categories['uncategorized']='Uncategorized';
      $categories = array_combine($categories, $categories);

      $fieldset_slide->addField('category', 'select', array(
          'label'     => Mage::helper('megatrongallery')->__('Category'),
          'class'     => '',
          'required'  => false,
          'name'      => 'category',
          'onclick' => "",
          'onchange' => "",
          'value'  => '1',
          'values' =>$categories ,
          'disabled' => false,
          'readonly' => false,
          'after_element_html' => '<small>Only for \'3d gallery with filters\'. Add new categories in Megatron Layout Gallery layout settings</small>',
          'tabindex' => 1
      ));

      $data = array();
      if ( Mage::getSingleton('adminhtml/session')->getmegatrongalleryData() )
      {
          $data = Mage::getSingleton('adminhtml/session')->getmegatrongalleryData();
      } elseif ( Mage::registry('megatrongallery_data') ) {
          $data = Mage::registry('megatrongallery_data')->getData();
      }

      $imgfront='';
      if (!empty($data['image']) )$imgfront = '<br/><a href="' . Mage::getBaseUrl('media').$data['image'] . '" target="_blank" >'."<img src=" . Mage::getBaseUrl('media').$data['image'] . " width='200px' alt='' /></a>";

      $fieldset_slide->addField('image', 'file', array(
          'label'     => Mage::helper('megatrongallery')->__('Slide Image'),
          'name'      => 'image',
          'note' => $imgfront,
          'class'=>'validate-file'
      ));

      $fieldset_slide->addField('caption', 'text', array(
          'label'     => Mage::helper('megatrongallery')->__('Title'),
          'required'  => true,
          'name'      => 'caption',
          'index'      => 'caption'
      ));

      $fieldset_slide->addField('sort', 'text', array(
          'label'     => Mage::helper('megatrongallery')->__('Sort pos.'),
          'class'=>'validate-digits required-entry',
          'name'      => 'sort',
          'index'     => 'sort',
          'required'  => true,
      ));

      $fieldset_slide->addField('status', 'select', array(
          'label'     => Mage::helper('megatrongallery')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('megatrongallery')->__('Active'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('megatrongallery')->__('Inactive'),
              ),
          ),
      ));

      if ( Mage::getSingleton('adminhtml/session')->getmegatrongalleryData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getmegatrongalleryData());
          Mage::getSingleton('adminhtml/session')->setmegatrongalleryData(null);
      } elseif ( Mage::registry('megatrongallery_data') ) {
          $form->setValues(Mage::registry('megatrongallery_data')->getData());
      }
      return parent::_prepareForm();
  }
}
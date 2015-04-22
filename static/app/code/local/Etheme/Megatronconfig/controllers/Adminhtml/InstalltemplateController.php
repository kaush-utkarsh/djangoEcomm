<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Megatronconfig_Adminhtml_InstalltemplateController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
        $this->loadLayout();
        $this->_addLeft($this->getLayout()->createBlock('core/text', 'leftside')->setText('<h2>Theme Install</h2>'));
        $this->_addContent($this->getLayout()->createBlock('megatronconfig/adminhtml_installtemplate_edit'));
        $this->_addContent($this->getLayout()->createBlock('core/text', 'faq')->setText('
        <h2>Auto Install</h2>
        <h4>If you click button \'Auto install\' automatically will be installed theme and imported needed megatron cms blocks and pages.</h4>
        <h6 style="color:red">Auto install will rewrite megatron cms blocks and pages if they were installed early.</h6>
        <h6 style="color:red">Don\'t forget disable System/Tools/Compilation before install if this mode enabled</h6>
        <br />
        <h2>Manual Install</h2>
        <ol style="list-style-type:">
            <li>1. Check that System/Tools/Compilation disabled</li>
            <li>2. Goto Etheme-Megatron/Install/Install cms block/pages and Click \'Submit action\'</li>
            <li>3. Goto System/Configuration/Design<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1 In field <b>Current Package Name</b> write <b>megatron</b><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2 In field <b>Themes/Default</b> write <b>default</b><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.3 Click \'Save\'
            </li>
            <li>4. Goto System/Configuration/Web<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.1 In field <b>CMS Home Page</b> select one of pages you want <b>Megatron Home page</b> / <b>Megatron Home Left+Right Sidebar</b> / <b>Megatron Home Right Sidebar</b> / <b>Megatron Home Izotope</b> / <b>Megatron Home + LeftSidebar</b> / <b>Megatron Home Corporate</b> / <b>Megatron Home Creative</b> <br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.2 In field <b>CMS No Route Page</b> select <b>Megatron 404</b><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.3 Click \'Save\'
            </li>
            <li>5. Goto System/Cache Management/ Click \'Flush Cache\'</li>
        </ol>
        '));

        $this->_setActiveMenu('etheme');
        $this->renderLayout();
	}

    public function installAction()
    {
        $store = 0;
        Mage::getModel('megatronconfig/content')->installTemplateResources(true);
        Mage::getModel('megatronconfig/content')->installTemplateBlocks(true);
        Mage::getModel('megatronconfig/content')->installTemplateConfig($store);
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('megatronconfig')->__("Megatron Template installed successfully. If you do not see changes please clean the cache.<br /><b>ATTENTION!!</b> Log out from magento admin panel if you are logged in. That is required step for final theme installation. Also this will avoid 404 page in theme settings"));
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }
}
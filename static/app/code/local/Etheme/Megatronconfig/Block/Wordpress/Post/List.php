<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 27.05.14
 * Time: 20:09
 * To change this template use File | Settings | File Templates.
 */ 
class Etheme_Megatronconfig_Block_Wordpress_Post_List extends Fishpig_Wordpress_Block_Post_List {
    /**
     * Get the post renderer template
     *
     * @return string
     */
    public function getPostRendererTemplate()
    {
        $template='wordpress/post/list/renderer/default.phtml';
        if(Mage::getStoreConfig('megatronlayout/options/blog_style') &&  (Mage::getSingleton('core/layout')->getBlock('root')->getTemplate()=='page/1column.phtml'))$template='wordpress/post/list/renderer/grid.phtml';
        if (!$this->hasPostRendererTemplate()) {
            $this->setPostRendererTemplate($template);
        }

        return $this->_getData('post_renderer_template');
    }
}
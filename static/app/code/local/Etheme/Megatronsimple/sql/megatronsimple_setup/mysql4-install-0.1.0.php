<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */
$installer = $this;
$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('megatronsimple')}`;
CREATE TABLE `{$this->getTable('megatronsimple')}` (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `image` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `store_id` varchar(255) NOT NULL default '',
  PRIMARY KEY (`slide_id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `{$this->getTable('megatronsimple')}` (`slide_id`, `image`, `link`, `status`, `store_id`) VALUES (1, 'etheme/megatron/megatronsimple/home_boxed_slider1.jpg', '#', 1, '0');
INSERT INTO `{$this->getTable('megatronsimple')}` (`slide_id`, `image`, `link`, `status`, `store_id`) VALUES (2, 'etheme/megatron/megatronsimple/home_boxed_slider2.jpg', '#', 1, '0');
INSERT INTO `{$this->getTable('megatronsimple')}` (`slide_id`, `image`, `link`, `status`, `store_id`) VALUES (3, 'etheme/megatron/megatronsimple/home_boxed_slider3.jpg', '#', 1, '0');

");
$installer->endSetup();





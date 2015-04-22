<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */
$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('megatrongallery')}`;
CREATE TABLE `{$this->getTable('megatrongallery')}` (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `image` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `page_id` varchar(255) NOT NULL default '',
  `caption` text NOT NULL default '',
  `category` varchar(255) NOT NULL default '',
  `sort` int(11) unsigned NOT NULL default '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `store_id` varchar(255) NOT NULL default '',
  PRIMARY KEY (`slide_id`)
) DEFAULT CHARSET=utf8;

");
$installer->endSetup();
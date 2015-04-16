<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */
$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('megatronrevolution')}`;
CREATE TABLE `{$this->getTable('megatronrevolution')}` (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `slide_html_code` text NOT NULL,
  `link` varchar(255) NOT NULL default '',
  `status` int(1) NOT NULL DEFAULT '1',
  `store_id` varchar(255) NOT NULL default '',
  PRIMARY KEY (`slide_id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `{$this->getTable('megatronrevolution')}` (`slide_id`, `slide_html_code`, `link`, `status`, `store_id`) VALUES (1, '', '#', 1, '0');
INSERT INTO `{$this->getTable('megatronrevolution')}` (`slide_id`, `slide_html_code`, `link`, `status`, `store_id`) VALUES (2, '', '#', 1, '0');
INSERT INTO `{$this->getTable('megatronrevolution')}` (`slide_id`, `slide_html_code`, `link`, `status`, `store_id`) VALUES (3, '', '#', 1, '0');

");
$installer->endSetup();
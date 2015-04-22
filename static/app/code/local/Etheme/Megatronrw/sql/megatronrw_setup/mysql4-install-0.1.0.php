<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */
$installer = $this;
$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('megatronrw')}`;
CREATE TABLE `{$this->getTable('megatronrw')}` (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `image` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `leftpos` int(3) NOT NULL DEFAULT '0',
  `toppos` int(3) NOT NULL DEFAULT '40',
  `width` float(4) NOT NULL DEFAULT '100',
  `extra` text NOT NULL default '',
  `caption` text NOT NULL default '',
  `status` int(1) NOT NULL DEFAULT '1',
  `store_id` varchar(255) NOT NULL default '',
  PRIMARY KEY (`slide_id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `{$this->getTable('megatronrw')}` (`slide_id`, `image`, `link`, `leftpos`, `toppos`, `width`, `extra`, `caption`, `status`, `store_id`) VALUES (1, 'etheme/megatron/megatronrw/slider-main-back-01.jpg', '#', '0.1', '36', '100', 'text-align: center', '<span style=\'font:15.9em/0.9em Mavenpro-black, Arial, Helvetica, sans-serif;color:#fff;opacity:.9;text-transform:uppercase;letter-spacing:-.06em\'>Sale</span><span style=\'font:5.5em/0.9em Mavenpro-medium, Arial, Helvetica, sans-serif;color:#fff;opacity:.9;letter-spacing:-.08em\'>up to 40% OFF</span>', 1, '0');
INSERT INTO `{$this->getTable('megatronrw')}` (`slide_id`, `image`, `link`, `leftpos`, `toppos`, `width`, `extra`, `caption`, `status`, `store_id`) VALUES (2, 'etheme/megatron/megatronrw/slider-main-back-02s.jpg', '#', '8', '44', '86', '', '<span style=\'margin-left:-.06em;font:10.8em/0.7em Mavenpro-black, Arial, Helvetica, sans-serif;color:#fff;opacity:.9; text-transform:uppercase;letter-spacing:-.06em\'>New</span><span style=\'font:3.7em/0.9em Mavenpro-medium, Arial, Helvetica, sans-serif;color:#fff; opacity:.9;text-transform:uppercase;letter-spacing:-.08em\'>collection</span><span style=\'font:4.6em/0.9em Mavenpro-black, Arial, Helvetica, sans-serif;color:#fff;opacity:.9;text-transform:uppercase;letter-spacing:-.08em\'>AUTUMN 2014</span>', 1, '0');
INSERT INTO `{$this->getTable('megatronrw')}` (`slide_id`, `image`, `link`, `leftpos`, `toppos`, `width`, `extra`, `caption`, `status`, `store_id`) VALUES (3, 'etheme/megatron/megatronrw/slider-main-back-03.jpg', '#', '50', '21', '44', '', '<span style=\'margin-left:-.06em;font:10.2em/0.75em Mavenpro-black, Arial, Helvetica, sans-serif;color:#fff;opacity:.9;text-transform:uppercase;letter-spacing:-.06em\'>Special offer</span><span style=\'padding:.3em 0 .5em;font:5.5em/0.9em Mavenpro-medium, Arial, Helvetica, sans-serif;color:#fff;opacity:.9;letter-spacing:-.08em\'>Save money with Lingerie SALE</span><span style=\'font:2.3em/0.9em Mavenpro-black, Arial, Helvetica, sans-serif;color:#fff;opacity:.9;text-transform:uppercase;letter-spacing:-.08em\'>Up to 50% OFF</span>', 1, '0');

");
$installer->endSetup();
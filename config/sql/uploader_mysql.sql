-- SVN FILE: $Id$
--
-- BaserCMS アップローダープラグイン SQL（MySQL）
--
-- Baser :  Basic Creating Support Project <http://basercms.net>
-- Copyright 2008 - 2009, Catchup, Inc.
--								18-1 nagao 1-chome, fukuoka-shi
--								fukuoka, Japan 814-0123
--
-- @copyright		Copyright 2008 - 2009, Catchup, Inc.
-- @link			http://basercms.net BaserCMS Project
-- @version			$Revision$
-- @modifiedby		$LastChangedBy$
-- @lastmodified	$Date$
-- @license			http://basercms.net/license/index.html

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- テーブルの構造 `bc__uploader_files`
--

CREATE TABLE IF NOT EXISTS `bc__uploader_files` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `alt` text default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

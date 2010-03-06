-- SVN FILE: $Id$
--
-- BaserCMS アップローダープラグイン SQL（SQLite）
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

--
-- テーブルの構造 bc__uploader_files
--

CREATE TABLE bc__uploader_files (
  id integer NOT NULL PRIMARY KEY,
  name text default NULL,
  alt text default NULL,
  created text default NULL,
  modified text default NULL
);
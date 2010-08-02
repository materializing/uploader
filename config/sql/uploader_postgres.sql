-- SVN FILE: $Id$
--
-- BaserCMS アップローダープラグイン SQL（PostgreSQL）
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
-- テーブルの構造 "bc__uploader_files"
--

CREATE SEQUENCE bc__uploader_files_id_seq;
CREATE TABLE "public"."bc__uploader_files" (
  "id" int8 NOT NULL default nextval('bc__uploader_files_id_seq'),
  "name" varchar(255) default NULL,
  "alt" text default NULL,
  "created" timestamp default NULL,
  "modified" timestamp default NULL,
  PRIMARY KEY  ("id")
) WITHOUT OIDS;
ALTER table "public"."bc__uploader_files" SET WITHOUT CLUSTER;

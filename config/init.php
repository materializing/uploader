<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーインストーラー
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2009, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2009, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			uploader.config
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * データベース初期化
 */
	$this->Plugin->initDatabase('plugin','uploader');
/**
 * 必要フォルダ初期化
 */
	$filesPath = WWW_ROOT.'files';
	$savePath = $filesPath.DS.'uploads';
	if(is_writable($filesPath) && !is_dir($savePath)){
		mkdir($savePath);
		chmod($savePath,0777);
	}
	if(!is_writable($savePath)){
		chmod($savePath,0777);
	}
?>
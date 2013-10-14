<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーインストーラー
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								1-19-4 ikinomatsubara, fukuoka-shi
 *								fukuoka, Japan 819-0055
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
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
	$this->Plugin->initDb('uploader');
/**
 * 必要フォルダ初期化
 */
	$filesPath = WWW_ROOT.'files';
	$savePath = $filesPath.DS.'uploads';
	$limitedPath = $savePath . DS . 'limited';
	
	if(is_writable($filesPath) && !is_dir($savePath)){
		mkdir($savePath);
	}
	if(!is_writable($savePath)){
		chmod($savePath, 0777);
	}
	if(is_writable($savePath) && !is_dir($limitedPath)){
		mkdir($limitedPath);
	}
	if(!is_writable($limitedPath)){
		chmod($limitedPath, 0777);
	}
	if(is_writable($limitedPath)){
		$File = new File($limitedPath . DS . '.htaccess');
		$htaccess = "Order allow,deny\nDeny from all";
		$File->write($htaccess);
		$File->close();
	}
	
?>
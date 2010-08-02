<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダー設定
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
$adminLink = '/admin/uploader/uploader_files/index';
$title = 'アップローダー';
if(!is_writable(WWW_ROOT.'files')){
	$viewFilesPath = str_replace(ROOT,'',WWW_ROOT).'files';	
	$installMessage = '登録ボタンをクリックする前に、サーバー上の '.$viewFilesPath.' に書き込み権限を与えてください。';
}
?>
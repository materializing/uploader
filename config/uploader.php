<?php
/* SVN FILE: $Id$ */
/**
 * フィード設定
 *
 * PHP versions 4 and 5
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2012, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 *
 * @copyright		Copyright 2008 - 2012, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			baser.config
 * @since			baserCMS v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * システムナビ
 */
	$config['BcApp.adminNavi.uploader'] = array(
			'name'		=> 'アップローダープラグイン',
			'contents'	=> array(
				array('name' => 'アップロードファイル一覧', 
					'url' => array('admin' => true, 'plugin' => 'uploader', 'controller' => 'uploader_files', 'action' => 'index')),
				array('name' => 'カテゴリ一覧', 
					'url' => array('admin' => true, 'plugin' => 'uploader', 'controller' => 'uploader_categories', 'action' => 'index')),
				array('name' => 'カテゴリ新規登録', 
					'url' => array('admin' => true, 'plugin' => 'uploader', 'controller' => 'uploader_categories', 'action' => 'add')),
				array('name' => '基本設定', 
					'url' => array('admin' => true, 'plugin' => 'uploader', 'controller' => 'uploader_configs', 'action' => 'index')),
		)
	);

?>
<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] アップローダーメニュー
 *
 * PHP versions 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2013, Catchup, Inc.
 *								1-19-4 ikinomatsubara, fukuoka-shi
 *								fukuoka, Japan 819-0055
 *
 * @copyright		Copyright 2008 - 2013, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			baser.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>


<tr>
	<th>アップローダーメニュー</th>
	<td>
		<ul>
			<li><?php $this->BcBaser->link('アップロードファイル一覧', array('plugin' => 'uploader', 'controller' => 'uploader_files', 'action' => 'index')) ?></li>
			<li><?php $this->BcBaser->link('カテゴリ一覧', array('plugin' => 'uploader', 'controller' => 'uploader_categories', 'action' => 'index')) ?></li>
			<li><?php $this->BcBaser->link('カテゴリ新規登録', array('plugin' => 'uploader', 'controller' => 'uploader_categories', 'action' => 'add')) ?></li>
			<li><?php $this->BcBaser->link('プラグイン基本設定', array('plugin' => 'uploader', 'controller' => 'uploader_configs', 'action' => 'index')) ?></li>
		</ul>
	</td>
</tr>

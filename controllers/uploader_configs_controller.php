<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーコントローラー
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			uploader.controllers
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * Include files
 */
App::import('Controller', 'Plugins');
/**
 * ファイルアップローダーコントローラー
 *
 * @package			uploader.controllers
 */
class UploaderConfigsController extends PluginsController {
/**
 * クラス名
 *
 * @var		string
 * @access	public
 */
	var $name = 'UploaderConfigs';
/**
 * モデル
 *
 * @var		array
 * @access	public
 */
	var $uses = array('Plugin', 'Uploader.UploaderConfig');
/**
 * コンポーネント
 *
 * @var		array
 * @access	public
 */
	var $components = array('AuthEx','Cookie','AuthConfigure');
/**
 * サブメニューエレメント
 *
 * @var 	array
 * @access 	public
 */
	var $subMenuElements = array('uploader');
/**
 * [ADMIN] アップローダー設定
 *
 * @return	void
 * @access	public
 */
	function admin_index() {
		
		$this->pageTitle = 'アップローダー設定';
		if(!$this->data) {
			$this->data['UploaderConfig'] = $this->UploaderConfig->findExpanded();
		} else {
			$this->UploaderConfig->set($this->data);
			if($this->UploaderConfig->validates()) {
				$this->UploaderConfig->saveKeyValue($this->data);
				$this->Session->setFlash('アップローダー設定を保存しました。');
				$this->redirect('index');
			} else {
				$this->Session->setFlash('入力エラーです。内容を修正してください。');
			}
		}
		
	}

}

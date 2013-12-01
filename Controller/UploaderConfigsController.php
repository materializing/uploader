<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーコントローラー
 *
 * PHP versions 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2013, Catchup, Inc.
 *								1-19-4 ikinomatsubara, fukuoka-shi
 *								fukuoka, Japan 819-0055
 *
 * @copyright		Copyright 2008 - 2013, Catchup, Inc.
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
class UploaderConfigsController extends BcPluginAppController {
/**
 * クラス名
 *
 * @var		string
 * @access	public
 */
	public $name = 'UploaderConfigs';
/**
 * モデル
 *
 * @var		array
 * @access	public
 */
	public $uses = array('Plugin', 'Uploader.UploaderConfig');
/**
 * コンポーネント
 *
 * @var		array
 * @access	public
 */
	public $components = array('BcAuth','Cookie','BcAuthConfigure');
/**
 * サブメニューエレメント
 *
 * @var 	array
 * @access 	public
 */
	public $subMenuElements = array('uploader');
/**
 * [ADMIN] アップローダー設定
 *
 * @return	void
 * @access	public
 */
	public function admin_index() {
		
		$this->pageTitle = 'アップローダー設定';
		if(!$this->request->data) {
			$this->request->data['UploaderConfig'] = $this->UploaderConfig->findExpanded();
		} else {
			$this->UploaderConfig->set($this->request->data);
			if($this->UploaderConfig->validates()) {
				$this->UploaderConfig->saveKeyValue($this->request->data);
				$this->setMessage('アップローダー設定を保存しました。');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->setMessage('入力エラーです。内容を修正してください。', true);
			}
		}
		
	}

}
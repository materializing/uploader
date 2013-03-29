<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーコントローラー
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
class UploaderFilesController extends PluginsController {
/**
 * クラス名
 *
 * @var		string
 * @access 	public
 */
	var $name = 'UploaderFiles';
/**
 * コンポーネント
 *
 * @var		array
 * @access	public
 */
	var $components = array('BcAuth','Cookie','BcAuthConfigure','RequestHandler');
/**
 * ヘルパー
 *
 * @var		array
 * @access	public
 */
	var $helpers = array(BC_TEXT_HELPER, BC_TIME_HELPER, BC_FORM_HELPER, 'Uploader.Uploader', 'BcUpload');
/**
 * ページタイトル
 *
 * @var		string
 * @access	public
 */
	var $pageTitle = 'アップローダープラグイン';
/**
 * モデル
 *
 * @var		array
 * @access	public
 */
	var $uses = array('Plugin','Uploader.UploaderFile', 'Uploader.UploaderConfig');
/**
 * ぱんくずナビ
 *
 * @var array
 * @access public
 */
	var $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
		array('name' => 'アップロードファイル管理', 'url' => array('controller' => 'uploader_files', 'action' => 'index'))
	);
/**
 * サブメニューエレメント
 *
 * @var 	array
 * @access 	public
 */
	var $subMenuElements = array('uploader');
/**
 * [ADMIN] ファイル一覧
 *
 * @param	int		$id		呼び出し元 識別ID
 * @param	string	$filter
 * @return	void
 * @access	public
 */
	function admin_index($id='') {

		if(!isset($this->siteConfigs['admin_list_num'])) {
			$this->siteConfigs['admin_list_num'] = 10;
		}
		$default = array('named' => array('num' => $this->siteConfigs['admin_list_num']));
		$this->setViewConditions('UploadFile', array('default' => $default));
		$this->set('uploaderConfigs', $this->UploaderConfig->findExpanded());
		$this->set('installMessage', $this->checkInstall());
		
		if($this->RequestHandler->isAjax()) {
			$settings = $this->UploaderFile->Behaviors->BcUpload->settings;
			$this->set('listId', $id);
			$this->set('imageSettings', $settings['fields']['name']['imagecopy']);
		} else {
			$this->search = 'uploader_files_index';
			$this->pageTitle = 'アップロードファイル一覧';
		}

	}
/**
 * インストール状態の確認
 *
 * @return	string	インストールメッセージ
 * @access	public
 */
	function checkInstall() {

		// インストール確認
		$installMessage = '';
		$viewFilesPath = str_replace(ROOT,'',WWW_ROOT).'files';
		$viewSavePath = $viewFilesPath.DS.$this->UploaderFile->actsAs['BcUpload']['saveDir'];
		$filesPath = WWW_ROOT.'files';
		$savePath = $filesPath.DS.$this->UploaderFile->actsAs['BcUpload']['saveDir'];
		if(!is_dir($savePath)) {
			$ret = mkdir($savePath,0777);
			if(!$ret) {
				if(is_writable($filesPath)) {
					$installMessage = $viewSavePath.' を作成し、書き込み権限を与えてください';
				}else {
					if(!is_dir($filesPath)) {
						$installMessage = $viewFilesPath.' 作成し、に書き込み権限を与えてください';
					}else {
						$installMessage = $viewFilesPath.' に書き込み権限を与えてください';
					}
				}
			}
		}else {
			if(!is_writable($savePath)) {
				$installMessage = $viewSavePath.' に書き込み権限を与えてください';
			}else {

			}
		}
		return $installMessage;

	}
/**
 * [ADMIN] ファイル一覧を表示
 *
 * ファイルアップロード時にリダイレクトされた場合、
 * RequestHandlerコンポーネントが作動しないので明示的に
 * レイアウト、デバッグフラグの設定をする
 *
 * @param	int		$id		呼び出し元 識別ID
 * @param	string	$filter
 * @return	void
 * @access	public
 */
	function admin_ajax_list($id='') {

		Configure::write('debug',0);
		
		$default = array('named' => array('num' => $this->siteConfigs['admin_list_num']));
		$this->setViewConditions('UploadFile', array('default' => $default, 'type' => 'get'));

		$this->data['Filter'] = $this->passedArgs;
		if(empty($this->data['Filter']['uploader_type'])) {
			$this->data['Filter']['uploader_type'] = 'all';
		}
		if(!empty($this->data['Filter']['name'])) {
			$this->data['Filter']['name'] = urldecode($this->data['Filter']['name']);
		}
			
		// =====================================================================
		// setViewConditions で type を get に指定した場合、
		// 自動的に $this->passedArgs['num'] 設定されないので明示的に取得
		// TODO setViewConditions の仕様を見直す
		// =====================================================================
		if($this->params['named']['num']) {
			$this->Session->write('UploaderFilesAdminAjaxList.named.num', $this->params['named']['num']);
		}
		if($this->Session->read('UploaderFilesAdminAjaxList.named.num')) {
			$num = $this->Session->read('UploaderFilesAdminAjaxList.named.num');
		} else {
			$num = $this->siteConfigs['admin_list_num'];
		}

		$conditions = $this->_createAdminIndexConditions($this->data['Filter']);
		$this->paginate = array('conditions'=>$conditions,
				'fields'=>array(),
				'order'=>'created DESC',
				'limit'=>$num
		);
		
		$dbDatas = $this->paginate('UploaderFile');
		
		foreach($dbDatas as $key => $dbData) {
			$files = $this->UploaderFile->filesExists($dbData['UploaderFile']['name']);
			$dbData = Set::merge($dbData,array('UploaderFile'=>$files));
			$dbDatas[$key] = $dbData;
		}
		
		$uploaderConfig = $this->UploaderConfig->findExpanded();
		$this->set('listId', $id);
		$this->set('files',$dbDatas);
		if(empty($uploaderConfig['layout_type'])) {
			$layoutType = 'panel';
		} else {
			$layoutType = 'table';
		}
		$this->set('layoutType', $uploaderConfig['layout_type']);
		
	}
/**
 * 一覧の検索条件を生成する
 * 
 * @param array $data
 * @return array 
 */
	function _createAdminIndexConditions($data) {
		
		$conditions = array();
		if(!empty($data['uploader_category_id'])) {
			$conditions = array('UploaderFile.uploader_category_id' => $data['uploader_category_id']);
			$this->data['Filter']['uploader_category_id'] = $data['uploader_category_id'];
		}
		if(!empty($data['uploader_type'])) {
			switch ($data['uploader_type']) {
				case 'img':
					$conditions['or'][] = array('UploaderFile.name LIKE' => '%.png');
					$conditions['or'][] = array('UploaderFile.name LIKE' => '%.jpg');
					$conditions['or'][] = array('UploaderFile.name LIKE' => '%.gif');
					break;
				case 'etc':
					$conditions['and'][] = array('UploaderFile.name NOT LIKE' => '%.png');
					$conditions['and'][] = array('UploaderFile.name NOT LIKE' => '%.jpg');
					$conditions['and'][] = array('UploaderFile.name NOT LIKE' => '%.gif');
					break;
				case 'all':
				case '':
			}
		}
		if(!empty($data['name'])) {
			$conditions['and']['or'][] = array('UploaderFile.name LIKE' => '%' . $data['name'] . '%');
			$conditions['and']['or'][] = array('UploaderFile.alt LIKE' => '%' . $data['name'] . '%');
		}
		
		return $conditions;
		
	}
/**
 * [ADMIN] Ajaxファイルアップロード
 *
 * jQueryのAjaxによるファイルアップロードの際、
 * RequestHandlerコンポーネントが作動しないので明示的に
 * レイアウト、デバッグフラグの設定をする
 *
 * @return 成功時：true　／　失敗時：null
 * @access public
 */
	function admin_ajax_upload() {

		$this->layout = 'ajax';
		Configure::write('debug',0);

		if(!$this->data) {
			$this->ajaxError(500, '無効な処理です。');
		}
		
		$user = $this->BcAuth->user();
		$userModel = $this->getUserModel();
		if(!empty($user[$userModel]['id'])) {
			$this->data['UploaderFile']['user_id'] = $user[$userModel]['id'];
		}
		$this->data['UploaderFile']['name'] = $this->data['UploaderFile']['file'];
		$this->data['UploaderFile']['alt'] = $this->data['UploaderFile']['name']['name'];
		$this->UploaderFile->create($this->data);

		if($this->UploaderFile->save()) {
			echo true;
		}
		
		exit();

	}
/**
 * [ADMIN] サイズを指定して画像タグを取得する
 *
 * @param	string	$name
 * @param	string	$size
 * @return	void
 * @access	public
 */
	function admin_ajax_image($name,$size='small') {

		$file = $this->UploaderFile->findByName(urldecode($name));
		$this->set('file',$file);
		$this->set('size',$size);

	}
/**
 * [ADMIN] 各サイズごとの画像の存在チェックを行う
 *
 * @param	string	$name
 * @return	void
 * @access	public
 */
	function admin_ajax_exists_images($name) {

		Configure::write('debug', 0);
		$this->RequestHandler->setContent('json');
		$this->RequestHandler->respondAs('application/json; charset=UTF-8');
		$files = $this->UploaderFile->filesExists($name);
		$this->set('result',$files);
		$this->render('json_result');
		
	}
/**
 * [ADMIN] 編集処理
 *
 * @return	void
 * @access	public
 */
	function admin_edit($id = null) {

		if (!$this->data && $this->RequestHandler->isAjax()) {
			$this->ajaxError(500, '無効な処理です。');
		} elseif(!$this->RequestHandler->isAjax() && !$id) {
			$this->notFound();
		}
		
		$user = $this->BcAuth->user();
		$userModel = $this->getUserModel();
		$uploaderConfig = $this->UploaderConfig->findExpanded();
		if($uploaderConfig['use_permission']) {
			if($user[$userModel]['user_group_id'] != 1 && $this->data['UploaderFile']['user_id'] != $user[$userModel]['id']) {
				$this->notFound();
			}
		}
		
		if(!$this->data) {
			$this->data = $this->UploaderFile->read(null, $id);
		} else {
			$this->UploaderFile->set($this->data);
			$result = $this->UploaderFile->save();
			if ($this->RequestHandler->isAjax()) {
				echo $result;
				exit();
			} else {
				if($result) {
					$this->setMessage('ファイルの内容を保存しました。');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->setMessage('保存中にエラーが発生しました。');
				}
			}	
		}
		
		$this->render('../elements/admin/uploader_files/form');

	}
/**
 * [ADMIN] 削除処理
 *
 * @return	void
 * @access	public
 */
	function admin_delete($id) {

		if(!$id) {
			$this->notFound();
		}

		$user = $this->BcAuth->user();
		$userModel = $this->getUserModel();
		$uploaderConfig = $this->UploaderConfig->findExpanded();
		$uploaderFile = $this->UploaderFile->read(null, $id);

		if(!$uploaderFile) {
			$this->notFound();
		}

		if($uploaderConfig['use_permission']) {
			if($user[$userModel]['user_group_id'] != 1 && $uploaderFile['UploaderFile']['user_id'] != $user[$userModel]['id']) {
				$this->notFound();
			}
		}

		$result = $this->UploaderFile->del($id);
		if ($this->RequestHandler->isAjax()) {
			echo $result;
			exit();
		} else {
			if($result) {
				$this->setMessage($uploaderFile['UploaderFile']['name']. ' を削除しました。', false, true);
			} else {
				$this->setMessage('削除中にエラーが発生しました。', true);
			}
			$this->redirect(array('action' => 'index'));
		}

	}
/**
 * 検索ボックスを取得する
 * 
 * @param string $listid
 */
	function admin_ajax_get_search_box($listId = "") {
		
		$this->set('listId', $listId);
		$this->render('../elements/admin/searches/uploader_files_index');
		
	}
}
?>
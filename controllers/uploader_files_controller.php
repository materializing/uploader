<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーコントローラー
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
	var $components = array('Auth','Cookie','AuthConfigure','RequestHandler');
	var $helpers = array('TimeEx','Uploader.Uploader');
	var $pageTitle = 'アップローダープラグイン';
	var $uses = array('Plugin','Uploader.UploaderFile');
/**
 * ファイル一覧
 *
 * @param	string	$filter
 * @return	void
 * @access	public
 */
	function admin_index($filter='') {

		$this->set('filter',$filter);
		$this->set('installMessage', $this->checkInstall());
		$this->pageTitle = 'ファイル一覧';

	}
/**
 * [AJAX] ファイル一覧
 * @param	string	$filter
 * @return	void
 * @access	public
 */
	function admin_ajax_index($filter='') {

		$this->set('filter',$filter);
		$this->set('installMessage', $this->checkInstall());

	}
/**
 * インストール状態の確認
 * @return	string	インストールメッセージ
 * @access	public
 */
	function checkInstall() {

		// インストール確認
		$installMessage = '';
		$viewFilesPath = str_replace(ROOT,'',WWW_ROOT).'files';
		$viewSavePath = $viewFilesPath.DS.$this->UploaderFile->actsAs['Upload']['saveDir'];
		$filesPath = WWW_ROOT.'files';
		$savePath = $filesPath.DS.$this->UploaderFile->actsAs['Upload']['saveDir'];
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
 * ファイル一覧を表示
 * ファイルアップロード時にリダイレクトされた場合、
 * RequestHandlerコンポーネントが作動しないので明示的に
 * レイアウト、デバッグフラグの設定をする
 * 
 * @param	string	$filter
 * @return	void
 * @access	public
 */
	function admin_ajax_list($filter='') {

		$this->layout = 'ajax';
		Configure::write('debug',0);

		if($filter=='image') {
			$conditions['or'][] = array('UploaderFile.name LIKE' => '%.png');
			$conditions['or'][] = array('UploaderFile.name LIKE' => '%.jpg');
			$conditions['or'][] = array('UploaderFile.name LIKE' => '%.gif');
		}else {
			$conditions = array();
		}
		$this->paginate = array('conditions'=>$conditions,
				'fields'=>array(),
				'order'=>'created DESC',
				'limit'=>10
		);
		$dbDatas = $this->paginate('UploaderFile');
		foreach($dbDatas as $key => $dbData) {
			$files = $this->UploaderFile->filesExists($dbData['UploaderFile']['name']);
			$dbData = Set::merge($dbData,array('UploaderFile'=>$files));
			$dbDatas[$key] = $dbData;
		}
		$this->set('files',$dbDatas);

	}
/**
 * Ajaxファイルアップロード
 * jQueryのAjaxによるファイルアップロードの際、
 * RequestHandlerコンポーネントが作動しないので明示的に
 * レイアウト、デバッグフラグの設定をする
 * 
 * @return 成功時：admin_ajax_list にリダイレクト　／　失敗時：false
 * @access public
 */
	function admin_ajax_upload() {

		$this->layout = 'ajax';
		Configure::write('debug',0);

		if(!$this->data) {
			$this->set('result',null);
			$this->render('ajax_result');
			return;
		}

		$this->data['UploaderFile']['name'] = $this->data['UploaderFile']['file'];
		$this->data['UploaderFile']['alt'] = $this->data['UploaderFile']['name']['name'];
		$this->UploaderFile->create($this->data);

		if($this->UploaderFile->save()) {
			$this->redirect(array('action'=>'ajax_list'));
		}else {
			$this->set('result',null);
			$this->render('ajax_result');
		}

	}
/**
 * サイズを指定して画像タグを取得する
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
 * 各サイズごとの画像の存在チェックを行う
 *
 * @param	string	$name
 * @return	void
 * @access	public
 */
	function admin_ajax_exists_images($name) {

		$this->RequestHandler->setContent('json');
		$this->RequestHandler->respondAs('application/json; charset=UTF-8');
		$files = $this->UploaderFile->filesExists($name);
		$this->set('result',$files);
		$this->render('json_result');

	}
/**
 * 編集処理
 *
 * @return	void
 * @access	public
 */
	function admin_edit() {

		if (!$this->data) {
			$this->notFound();
		}

		$this->UploaderFile->set($this->data);
		$this->set('result',$this->UploaderFile->save());
		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax_result');
		}

	}
/**
 * 削除処理
 *
 * @return	void
 * @access	public
 */
	function admin_delete() {

		if(!$this->data) {
			$this->notFound();
		}

		$this->set('result',$this->UploaderFile->del($this->data['UploaderFile']['id']));
		if ($this->RequestHandler->isAjax()) {
			$this->render('ajax_result');
		}

	}
}
?>